<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadConversionTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
    }

    public function test_lead_can_be_converted_to_customer(): void
    {
        $lead = Lead::create([
            'contact_name' => 'Pak Budi',
            'organization' => 'SMPN 1 Cikarang',
            'phone' => '081234567890',
            'email' => 'budi@smpn1.id',
            'status' => 'new',
            'notes' => 'Interested in attributes',
        ]);

        $this->actingAs($this->admin())
            ->post(route('admin.leads.convert-to-customer', $lead))
            ->assertRedirect();

        // Verify customer was created
        $this->assertDatabaseHas('customers', [
            'name' => 'Pak Budi',
            'organization' => 'SMPN 1 Cikarang',
            'phone' => '081234567890',
            'email' => 'budi@smpn1.id',
        ]);

        // Verify lead is linked to customer
        $lead->refresh();
        $this->assertNotNull($lead->customer_id);
        $this->assertEquals('Pak Budi', $lead->customer->name);
    }

    public function test_converted_lead_does_not_create_duplicate_customer(): void
    {
        $customer = Customer::create(['name' => 'Existing Customer', 'phone' => '081234567890']);

        $lead = Lead::create([
            'contact_name' => 'Existing Customer',
            'customer_id' => $customer->id,
            'phone' => '081234567890',
            'status' => 'new',
        ]);

        $this->actingAs($this->admin())
            ->post(route('admin.leads.convert-to-customer', $lead))
            ->assertRedirect();

        // Should redirect to existing customer, not create new
        $this->assertEquals(1, Customer::where('phone', '081234567890')->count());
    }
}
