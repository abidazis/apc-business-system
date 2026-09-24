<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create super admin for auth
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@example.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);
    }

    public function test_super_admin_can_view_user_list(): void
    {
        $this->actingAs(User::first());

        $response = $this->get('/admin/users');

        $response->assertOk();
    }

    public function test_super_admin_can_create_user(): void
    {
        $this->actingAs(User::first());

        $response = $this->post('/admin/users', [
            'name' => 'New Staff',
            'email' => 'staff@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'staff',
            'is_active' => true,
        ]);

        $response->assertRedirect('/admin/users');

        $this->assertDatabaseHas('users', [
            'name' => 'New Staff',
            'email' => 'staff@example.com',
            'role' => 'staff',
        ]);
    }

    public function test_super_admin_can_toggle_user_active_status(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs(User::first());

        $response = $this->patch("/admin/users/{$user->id}/toggle-active");

        $response->assertRedirect();

        $user->refresh();
        $this->assertFalse($user->is_active);
    }

    public function test_admin_cannot_access_user_management(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/users/create');

        // Admin can see the page but should see access denied message
        $response->assertOk();
        $response->assertSee('Akses Ditolak');
    }
}
