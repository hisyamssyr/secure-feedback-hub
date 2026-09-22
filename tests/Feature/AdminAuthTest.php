<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@student.its.ac.id',
            'password' => bcrypt('rahasia123'),
        ]);

        $response = $this->post(route('admin.authenticate'), [
            'email' => 'admin@student.its.ac.id',
            'password' => 'rahasia123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_cannot_login_with_wrong_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@student.its.ac.id',
            'password' => bcrypt('rahasia123'),
        ]);

        $response = $this->post(route('admin.authenticate'), [
            'email' => 'admin@student.its.ac.id',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertInvalid(['email']);
    }

    public function test_dashboard_lists_feedback(): void
    {
        $user = User::factory()->create();
        Feedback::factory()->create(['name' => 'Budi Tester']);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Budi Tester');
    }

    public function test_admin_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('admin.logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
