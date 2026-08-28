<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentRequest;
use App\Models\Order;
use App\Models\Payment;
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
        Payment::create($data);
        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran dicatat.');
    }

    public function edit(Payment $payment)
    {
        $orders = Order::whereNotIn('status', ['cancelled'])->with('customer')->limit(200)->get();
        return view('admin.payments.edit', compact('payment', 'orders'));
    }

    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran dihapus.');
    }
}