<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\ExcoMember;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutManagerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_access_about_us_manager_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.about'));
        $response->assertStatus(200);
        $response->assertSee('About Us Page Manager');
        $response->assertSee('Welcome Address');
        $response->assertSee('NUESA Executive Council (Excos)');
    }

    public function test_admin_can_update_about_us_settings(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('admin.about.settings.update'), [
            'about_president_name' => 'Comr. New President Name',
            'about_president_title' => 'NUESA President (2026/2027 Session)',
            'about_president_quote' => 'Innovating future engineering standards.',
            'about_president_speech' => 'Welcome to the newly updated NUESA portal.',
            'about_overview' => 'NUESA represents thousands of engineering scholars.',
            'about_mission' => 'Empower through mentorship and innovation.',
            'about_vision' => 'Leading engineering education in West Africa.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEquals('Comr. New President Name', SiteSetting::get('about_president_name'));
        $this->assertEquals('Innovating future engineering standards.', SiteSetting::get('about_president_quote'));

        // Verify public about page displays updated content
        $publicResponse = $this->get(route('about'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Comr. New President Name');
        $publicResponse->assertSee('Innovating future engineering standards.');
        $publicResponse->assertSee('Leading engineering education in West Africa.');
    }

    public function test_admin_can_add_and_delete_exco_member(): void
    {
        $admin = User::where('role', 'admin')->first();
        $dept = Department::first();

        // Add Exco
        $response = $this->actingAs($admin)->post(route('admin.about.exco.store'), [
            'name' => 'Comr. Special Officer',
            'office_position' => 'Director of Academics',
            'department_id' => $dept->id,
            'twitter_handle' => '@special_officer',
            'linkedin_url' => 'linkedin.com/in/special',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $exco = ExcoMember::where('name', 'Comr. Special Officer')->first();
        $this->assertNotNull($exco);
        $this->assertEquals('Director of Academics', $exco->office_position);

        // Delete Exco
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.about.exco.destroy', $exco->id));
        $deleteResponse->assertRedirect();

        $this->assertDatabaseMissing('exco_members', ['id' => $exco->id]);
    }
}
