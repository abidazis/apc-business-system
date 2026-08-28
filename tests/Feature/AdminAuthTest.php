<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_screen_renders(): void
    {
        $this->get('/admin/login')->assertOk()->assertSee('Admin Login');
    }

    public function test_admin_dashboard_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role' => User::ROLE_SUPER_ADMIN,
            'is_active' => true,
        ]);

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/admin');

        $this->actingAs($user)->get('/admin/dashboard')->assertOk();
    }

    public function test_invalid_credentials_rejected(): void
    {
        User::factory()->create([
            'password' => bcrypt('password'),
            'role' => User::ROLE_SUPER_ADMIN,
            'is_active' => true,
        ]);

        $this->post('/admin/login', ['email' => 'no@where.com', 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role' => User::ROLE_ADMIN,
            'is_active' => false,
        ]);

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors('email');
    }

    public function test_logout_works(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
            'is_active' => true,
        ]);
        $this->actingAs($user)->post('/admin/logout')->assertRedirect('/admin/login');
    }
}
