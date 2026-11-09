<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('NUESA UNIMAID');
    }

    public function test_public_about_page_loads_successfully(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('About NUESA UNIMAID');
    }

    public function test_public_resources_page_loads_successfully(): void
    {
        $response = $this->get('/resources');
        $response->assertStatus(200);
        $response->assertSee('Course Vault');
    }

    public function test_public_team_page_loads_successfully(): void
    {
        $response = $this->get('/team');
        $response->assertStatus(200);
        $response->assertSee('Staff Directory');
    }

    public function test_public_gallery_page_loads_successfully(): void
    {
        $response = $this->get('/gallery');
        $response->assertStatus(200);
        $response->assertSee('Faculty Engineering Gallery');
    }

    public function test_public_album_page_loads_successfully(): void
    {
        $response = $this->get('/album');
        $response->assertStatus(200);
        $response->assertSee('Student Album');
    }

    public function test_public_news_details_page_loads_successfully(): void
    {
        $response = $this->get('/news/nuesa-annual-engineering-week-2026-kickoff');
        $response->assertStatus(200);
        $response->assertSee('Article Details');
    }

    public function test_demo_receipt_pdf_generation(): void
    {
        $response = $this->get('/receipt/demo');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_loads_successfully(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Executive Command Center');
    }

    public function test_admin_album_page_loads_successfully(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/album');
        $response->assertStatus(200);
        $response->assertSee('Student Album Profiles');
    }


    public function test_unauthenticated_user_redirected_from_admin(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_redirected_from_student_dashboard(): void
    {
        $response = $this->get('/student/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_student_dashboard_loads_successfully(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->get('/student/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Welcome back');
    }

    public function test_student_digital_id_page_loads_successfully(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->get('/student/digital-id');
        $response->assertStatus(200);
        $response->assertSee('Digital Student ID');
    }

    public function test_student_dues_page_loads_successfully(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->get('/student/dues');
        $response->assertStatus(200);
        $response->assertSee('Departmental Dues');
    }

    public function test_student_vault_page_loads_successfully(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->get('/student/vault');
        $response->assertStatus(200);
        $response->assertSee('Course Vault');
    }

    public function test_student_elections_page_loads_successfully(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->get('/student/elections');
        $response->assertStatus(200);
        $response->assertSee('E-Voting Portal');
    }

    public function test_student_profile_page_loads_successfully(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->get('/student/profile');
        $response->assertStatus(200);
        $response->assertSee('Student Biodata');
    }

    public function test_student_can_update_profile(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->put('/student/profile', [
            'name' => 'Comr. Updated Student',
            'phone' => '+234 811 222 3333',
            'level' => '500L',
            'matric_number' => '18/04/01/0101',
        ]);

        $response->assertRedirect('/student/profile');
        $this->assertDatabaseHas('users', [
            'name' => 'Comr. Updated Student',
            'phone' => '+234 811 222 3333',
        ]);
    }

    public function test_student_dues_payment_is_unavailable(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $before = \App\Models\Payment::count();
        $response = $this->actingAs($student)->post('/student/pay-dues', [
            'matric_number' => '18/04/01/0101',
            'amount' => 3500.00,
        ]);

        $response->assertRedirect('/student/dues');
        $response->assertSessionHas('error');
        $this->assertSame($before, \App\Models\Payment::count());
    }

    public function test_students_cannot_upload_vault_material(): void
    {
        $student = \App\Models\User::factory()->create(['role' => 'student']);
        $file = \Illuminate\Http\UploadedFile::fake()->create('lecture_note.pdf', 500, 'application/pdf');

        $this->actingAs($student)->post('/student/vault/upload', ['title' => 'x', 'course_code' => 'X', 'resource_file' => $file])
            ->assertNotFound();
        $this->actingAs($student)->get('/student/vault')->assertOk()->assertDontSee('Upload Material');
        $this->assertDatabaseMissing('academic_resources', ['title' => 'x']);
    }

    public function test_logout_clears_session_for_student_and_admin(): void
    {
        $student = \App\Models\User::factory()->create(['role' => 'student']);
        $this->actingAs($student)->post('/logout')->assertRedirect('/login');
        $this->assertGuest();

        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_login_page_is_not_prefilled(): void
    {
        $this->get('/login')->assertOk()->assertDontSee('value="ismail', false);
    }

    public function test_student_can_cast_election_vote(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->post('/student/elections/vote', [
            'choices' => \App\Models\ElectionCandidate::all()->groupBy('office')->map(fn ($g) => $g->first()->id)->all(),
        ]);

        $response->assertRedirect('/student/elections');
        $response->assertSessionHas('success');
    }

    public function test_unauthenticated_user_is_redirected_from_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Executive Admin Portal');
    }


    public function test_admin_user_can_login_and_access_admin_dashboard(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name' => 'Test Admin',
                'email' => 'admin@test.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin',
            ]);
        }

        $response = $this->post('/admin/login', [
            'login_id' => $admin->email,
            'password' => 'password123',
        ]);


        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_can_toggle_student_clearance_status(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($admin)->post('/admin/users/' . $student->id . '/toggle-verification');
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_admin_notifications_page_loads_successfully(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/notifications');
        $response->assertStatus(200);
        $response->assertSee('Send Student Portal Notification');
    }

    public function test_admin_can_send_broadcast_notification(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/notifications/send', [
            'title' => 'Urgent Portal Maintenance Alert',
            'message' => 'The e-portal will undergo maintenance tonight at 12 AM.',
            'type' => 'warning',
            'user_id' => null,
        ]);

        $response->assertRedirect('/admin/notifications');
        $this->assertDatabaseHas('portal_notifications', [
            'title' => 'Urgent Portal Maintenance Alert',
            'type' => 'warning',
        ]);
    }

    public function test_admin_payments_page_loads_and_records_payment(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/payments');
        $response->assertStatus(200);
        $response->assertSee('Payments & Revenue Control');

        $storeResponse = $this->actingAs($admin)->post('/admin/payments', [
            'student_name' => 'Comr. Test Student',
            'matric_number' => '22/05/01/9999',
            'category' => 'Faculty Dues',
            'amount' => 3500.00,
            'channel' => 'Bank Transfer',
        ]);
        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('payments', [
            'amount' => 3500.00,
            'payment_type' => 'Faculty Dues',
        ]);
    }

    public function test_admin_elections_page_loads_and_manages_candidates(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/elections');
        $response->assertStatus(200);
        $response->assertSee('General Elections Governance');

        $candResponse = $this->actingAs($admin)->post('/admin/elections/candidate', [
            'name' => 'Comr. Test Candidate',
            'office' => 'PRESIDENT',
            'matric_number' => '22/05/04/8888',
            'department' => 'Computer Engineering',
            'level' => '500L',
        ]);
        $candResponse->assertRedirect();
        $this->assertDatabaseHas('election_candidates', [
            'name' => 'Comr. Test Candidate',
            'office' => 'PRESIDENT',
        ]);
    }

    public function test_admin_posts_and_create_post_pages_load_and_store_post(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);

        $createViewResponse = $this->actingAs($admin)->get('/admin/posts/create');
        $createViewResponse->assertStatus(200);
        $createViewResponse->assertSee('Create Official Announcement');

        $storeResponse = $this->actingAs($admin)->post('/admin/posts', [
            'title' => 'Test Announcement Post Title',
            'category' => 'Elections',
            'summary' => 'Summary excerpt of announcement',
            'body' => 'Full body content of announcement.',
            'is_published' => 'PUBLISHED',
        ]);
        $storeResponse->assertRedirect('/admin/posts');
        $this->assertDatabaseHas('news_posts', [
            'title' => 'Test Announcement Post Title',
            'category' => 'Elections',
        ]);
    }

    public function test_admin_login_authentication_with_valid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'login_id' => 'admin@nuesaunimaid.org.ng',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    public function test_student_login_authentication_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'login_id' => 'ismail.yusuf@eng.unimaid.edu.ng',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertAuthenticated();
    }

    public function test_student_logout_flow(): void
    {
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($student)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_election_synchronization_and_student_voting_flow(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::factory()->create(['role' => 'admin']);
        $student = \App\Models\User::where('role', 'student')->first() ?? \App\Models\User::factory()->create(['role' => 'student']);

        // 1. Admin updates parameters and status
        $this->actingAs($admin)->post('/admin/elections/parameters', [
            'title' => 'NUESA UNIMAID General Elections 2025/2026',
            'session' => '2025/2026 Session',
            'date' => '2026-10-25',
            'officer' => 'Engr. Dr. Mustapha Hassan',
            'start_time' => '08:00',
            'end_time' => '17:00',
        ])->assertRedirect();

        $this->actingAs($admin)->post('/admin/elections/status', [
            'status' => 'LIVE',
        ])->assertRedirect();

        // 2. Admin adds candidate
        $this->actingAs($admin)->post('/admin/elections/candidate', [
            'name' => 'Comr. Election Candidate Sync',
            'office' => 'PRESIDENT',
            'department' => 'Computer Engineering',
            'level' => '500L',
        ])->assertRedirect();

        $candidate = \App\Models\ElectionCandidate::where('name', 'Comr. Election Candidate Sync')->first();
        $this->assertNotNull($candidate);

        // 3. Student views elections page and sees synchronized title & candidate
        $studentPageResponse = $this->actingAs($student)->get('/student/elections');
        $studentPageResponse->assertStatus(200);
        $studentPageResponse->assertSee('NUESA UNIMAID GENERAL ELECTIONS 2025/2026');
        $studentPageResponse->assertSee('Comr. Election Candidate Sync');

        // 4. Student votes for candidate
        $voteResponse = $this->actingAs($student)->post('/student/elections/vote', [
            'choices' => \App\Models\ElectionCandidate::all()->groupBy('office')->map(fn ($g) => $g->first()->id)->all(),
        ]);
        $voteResponse->assertRedirect('/student/elections');

        $this->assertDatabaseHas('election_candidates', [
            'id' => \App\Models\ElectionCandidate::where('office', 'PRESIDENT')->orderBy('id')->value('id'),
            'votes' => 1,
        ]);
    }
}




