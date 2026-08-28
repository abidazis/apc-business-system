<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Services\NumberGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceAndFinanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_number_format(): void
    {
        $n = NumberGenerator::invoiceNumber();
        $this->assertMatchesRegularExpression('/^INV-\d{4}-\d{2}-\d{4}$/', $n);
    }

    public function test_payment_status_unpaid_partial_paid(): void
    {
        $customer = \App\Models\Customer::create(['name' => 'C']);
        $order = Order::create([
            'order_number' => 'ORD-TEST-1',
            'customer_id' => $customer->id,
            'order_date' => now(),
            'status' => 'confirmed',
            'total' => 100000,
        ]);

        $this->assertEquals('unpaid', $order->payment_status);

        Payment::create(['order_id' => $order->id, 'payment_date' => now(), 'amount' => 30000, 'method' => 'cash']);
        $order->refresh();
        $this->assertEquals('partial', $order->payment_status);

        Payment::create(['order_id' => $order->id, 'payment_date' => now(), 'amount' => 70000, 'method' => 'cash']);
        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
    }

    public function test_super_admin_can_manage_invoices(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
        $this->actingAs($user)->get('/admin/invoices')->assertOk();
    }

    public function test_non_admin_cannot_access_admin(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_STAFF, 'is_active' => true]);
        // Staff role doesn't satisfy admin.access Gate; controller returns 403.
        $this->actingAs($user)->get('/admin/dashboard')->assertStatus(403);
    }
}
