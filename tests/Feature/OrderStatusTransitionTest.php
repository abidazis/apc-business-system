<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStatusTransitionTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $customer = Customer::create([
            'name' => 'Test Customer',
        ]);

        $this->order = Order::create([
            'order_number' => 'ORD-001',
            'customer_id' => $customer->id,
            'order_date' => now(),
            'status' => 'lead',
            'total' => 100000,
        ]);
    }

    public function test_order_can_transition_to_valid_next_status(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/admin/orders/{$this->order->id}/status", [
                'status' => 'quotation',
            ]);

        $response->assertRedirect();
        $this->order->refresh();
        $this->assertEquals('quotation', $this->order->status);
    }

    public function test_order_cannot_skip_status_workflow(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/admin/orders/{$this->order->id}/status", [
                'status' => 'completed',
            ]);

        $response->assertSessionHasErrors('status');
        $this->order->refresh();
        $this->assertEquals('lead', $this->order->status);
    }

    public function test_completed_order_cannot_change_status(): void
    {
        $this->order->update(['status' => 'completed']);

        $response = $this->actingAs($this->admin)
            ->post("/admin/orders/{$this->order->id}/status", [
                'status' => 'production',
            ]);

        $response->assertSessionHasErrors('status');
    }

    public function test_order_status_transitions_follow_workflow(): void
    {
        $workflow = ['lead', 'quotation', 'confirmed', 'dp_received', 'design', 'production', 'quality_control', 'ready_to_deliver'];

        // Test forward progression
        foreach ($workflow as $index => $status) {
            if ($index === 0) {
                continue;
            } // Skip first, already 'lead'

            $previousStatus = $workflow[$index - 1];
            $this->order->update(['status' => $previousStatus]);

            $response = $this->actingAs($this->admin)
                ->post("/admin/orders/{$this->order->id}/status", [
                    'status' => $status,
                ]);

            $response->assertRedirect();
            $this->order->refresh();
            $this->assertEquals($status, $this->order->status);
        }
    }
}
