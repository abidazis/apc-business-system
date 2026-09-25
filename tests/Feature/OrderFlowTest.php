<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
    }

    public function test_order_create_page_loads(): void
    {
        $customer = Customer::create(['name' => 'Test Customer', 'phone' => '08123456789']);

        $response = $this->actingAs($this->admin())
            ->get('/admin/orders/create');

        $response->assertOk();
        $response->assertSee($customer->name);
    }

    public function test_order_total_calculation(): void
    {
        $customer = Customer::create(['name' => 'Cust']);
        $order = Order::create([
            'order_number' => 'TEST-0001-01-2026',
            'customer_id' => $customer->id,
            'order_date' => now(),
            'status' => 'lead',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'description' => 'Item A',
            'quantity' => 2,
            'unit_price' => 100000,
            'hpp' => 50000,
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'description' => 'Item B',
            'quantity' => 1,
            'unit_price' => 50000,
            'hpp' => 20000,
        ]);

        $order->refresh()->recalculateTotals();
        $order->refresh();

        $this->assertEquals(250000.0, (float) $order->subtotal); // 2*100k + 1*50k
        $this->assertEquals(250000.0, (float) $order->total); // no discount/shipping
        $this->assertEquals(120000.0, (float) $order->hpp_total); // 2*50k + 1*20k
        $this->assertEquals(130000.0, (float) $order->gross_profit); // 250k - 120k
    }

    public function test_order_outstanding_calculation(): void
    {
        $customer = Customer::create(['name' => 'Cust']);
        $order = Order::create([
            'order_number' => 'TEST-0002-01-2026',
            'customer_id' => $customer->id,
            'order_date' => now(),
            'status' => 'confirmed',
            'total' => 1000000,
        ]);

        $this->assertEquals(1000000.0, $order->outstanding);
        $this->assertEquals('unpaid', $order->payment_status);

        Payment::create([
            'order_id' => $order->id,
            'payment_date' => now(),
            'amount' => 400000,
            'method' => 'bank_transfer',
        ]);

        $order->refresh();
        $this->assertEquals(600000.0, $order->outstanding);
        $this->assertEquals('partial', $order->payment_status);

        Payment::create([
            'order_id' => $order->id,
            'payment_date' => now(),
            'amount' => 600000,
            'method' => 'bank_transfer',
        ]);

        $order->refresh();
        $this->assertEquals(0.0, $order->outstanding);
        $this->assertEquals('paid', $order->payment_status);
    }

    public function test_order_number_format(): void
    {
        $customer = Customer::create(['name' => 'Cust']);
        $this->actingAs($this->admin())
            ->post('/admin/orders', [
                'customer_id' => $customer->id,
                'order_date' => now()->format('Y-m-d'),
                'status' => 'confirmed',
                'items' => [
                    ['description' => 'A', 'quantity' => 1, 'unit_price' => 100000, 'hpp' => 50000],
                ],
            ])
            ->assertRedirect();

        $first = Order::first();
        $this->assertMatchesRegularExpression('/^ORD-\d{4}-\d{2}-\d{4}$/', $first->order_number);
    }

    public function test_lead_to_order_conversion(): void
    {
        $customer = Customer::create(['name' => 'Cust']);
        $lead = Lead::create([
            'contact_name' => 'Pak Budi',
            'phone' => '081234567890',
            'status' => 'new',
            'customer_id' => $customer->id,
        ]);

        $this->actingAs($this->admin())
            ->post('/admin/orders', [
                'customer_id' => $customer->id,
                'lead_id' => $lead->id,
                'order_date' => now()->format('Y-m-d'),
                'status' => 'lead',
                'items' => [
                    ['description' => 'A', 'quantity' => 1, 'unit_price' => 100000, 'hpp' => 50000],
                ],
            ])
            ->assertRedirect();

        // Lead should be marked as won
        $lead->refresh();
        $this->assertEquals('won', $lead->status);
    }
}
