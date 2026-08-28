<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerLeadTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
    }

    public function test_customer_can_be_created(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/customers', [
                'name' => 'SMAN 1 Cikarang',
                'organization' => 'SMAN 1 Cikarang',
                'phone' => '08123',
                'email' => 'test@example.com',
            ])
            ->assertRedirect('/admin/customers');

        $this->assertDatabaseHas('customers', ['name' => 'SMAN 1 Cikarang']);
    }

    public function test_customer_email_validation(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/customers', [
                'name' => 'X',
                'email' => 'not-an-email',
            ])
            ->assertSessionHasErrors('email');
    }

    public function test_lead_can_be_created(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/leads', [
                'contact_name' => 'Pak Budi',
                'phone' => '08123',
                'status' => 'new',
            ])
            ->assertRedirect('/admin/leads');

        $this->assertDatabaseHas('leads', ['contact_name' => 'Pak Budi', 'status' => 'new']);
    }
}
