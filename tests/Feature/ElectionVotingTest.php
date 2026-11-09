<?php

namespace Tests\Feature;

use App\Models\ElectionCandidate;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElectionVotingTest extends TestCase
{
    use RefreshDatabase;

    private function ballot(): array
    {
        $choices = [];
        foreach (['PRESIDENT', 'VICE PRESIDENT'] as $office) {
            $choices[$office] = ElectionCandidate::create([
                'name' => "Cand $office", 'office' => $office, 'department' => 'CPE', 'level' => '400L', 'votes' => 0,
            ])->id;
        }
        return $choices;
    }

    public function test_student_can_vote_once_and_results_hidden(): void
    {
        $choices = $this->ballot();
        $user = User::factory()->create(['role' => 'student']);

        $this->actingAs($user)->post('/student/elections/vote', ['choices' => $choices])
            ->assertSessionHas('success');
        $this->assertDatabaseCount('election_votes', 2);

        $this->actingAs($user)->post('/student/elections/vote', ['choices' => $choices])
            ->assertSessionHas('error');
        $this->assertDatabaseCount('election_votes', 2);
        $this->assertEquals(1, ElectionCandidate::first()->votes);

        $this->actingAs($user)->get('/student/elections')->assertOk()->assertDontSee('Final Election Results');
    }

    public function test_incomplete_ballot_rejected_and_results_shown_when_concluded(): void
    {
        $choices = $this->ballot();
        $user = User::factory()->create(['role' => 'student']);

        $this->actingAs($user)->post('/student/elections/vote', ['choices' => array_slice($choices, 0, 1)])
            ->assertSessionHas('error');
        $this->assertDatabaseCount('election_ballots', 0);

        SiteSetting::set('election_status', 'CONCLUDED');
        $this->actingAs($user)->get('/student/elections')->assertSee('Final Election Results');
        $this->actingAs($user)->post('/student/elections/vote', ['choices' => $choices])->assertSessionHas('error');
    }

    public function test_roles_are_separated(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student)->get('/admin')->assertForbidden();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get('/student/dashboard')->assertRedirect(route('admin.dashboard'));
    }
}
