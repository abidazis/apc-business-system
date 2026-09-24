<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Activity;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('order.customer')
            ->when($request->get('order'), fn ($q, $id) => $q->where('order_id', $id))
            ->when($request->get('method'), fn ($q, $m) => $q->where('method', $m))
            ->latest('payment_date')
            ->paginate(25)
            ->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $orders = Order::whereNotIn('status', ['cancelled'])
            ->with('customer')
            ->orderByDesc('order_date')
            ->limit(200)
            ->get();
        $selected = $request->filled('order') ? Order::find($request->order) : null;

        return view('admin.payments.create', compact('orders', 'selected'));
    }

    public function store(PaymentRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $payment = Payment::create($data);
        Activity::record('payment.recorded', $payment, [
            'order_id' => $payment->order_id,
            'amount' => (float) $payment->amount,
        ]);

        // Auto-update invoice status if exists
        $this->syncInvoiceStatus($payment->order);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran dicatat.');
    }

    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        Activity::record('payment.updated', $payment, ['amount' => (float) $payment->amount]);

        // Auto-update invoice status if exists
        $this->syncInvoiceStatus($payment->order);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $order = $payment->order;
        $paymentId = $payment->id;
        $payment->delete();
        Activity::record('payment.deleted', null, ['payment_id' => $paymentId]);

        // Auto-update invoice status if exists
        $this->syncInvoiceStatus($order);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran dihapus.');
    }

    private function syncInvoiceStatus(Order $order): void
    {
        $invoice = $order->invoice;
        if (! $invoice) {
            return;
        }

        $totalPaid = (float) $order->payments()->sum('amount');
        $total = (float) $order->total;

        if ($totalPaid <= 0) {
            $invoice->update(['status' => 'unpaid']);
        } elseif ($totalPaid >= $total) {
            $invoice->update(['status' => 'paid']);
        } else {
            $invoice->update(['status' => 'partial']);
        }
    }
}
