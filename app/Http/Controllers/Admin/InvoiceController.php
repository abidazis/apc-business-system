<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvoiceRequest;
use App\Models\Invoice;
use App\Models\Order;
use App\Services\NumberGenerator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['customer', 'order'])
            ->when($request->get('q'), fn ($q, $term) =>
                $q->where('invoice_number', 'like', "%{$term}%")
                  ->orWhereHas('customer', fn ($qq) => $qq->where('name', 'like', "%{$term}%")))
            ->when($request->get('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest('issue_date')
            ->paginate(25)
            ->withQueryString();
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $order = $request->filled('order') ? Order::with('customer', 'items', 'payments')->find($request->order) : null;
        if ($order && $order->invoice) {
            return redirect()->route('admin.invoices.show', $order->invoice);
        }
        $orders = Order::whereNotIn('status', ['cancelled'])
            ->whereDoesntHave('invoice')
            ->with('customer')
            ->orderByDesc('order_date')
            ->limit(200)
            ->get();
        return view('admin.invoices.create', compact('orders', 'order'));
    }

    public function store(InvoiceRequest $request)
    {
        $order = Order::with('items', 'payments')->findOrFail($request->order_id);

        if ($order->invoice) {
            return redirect()->route('admin.invoices.show', $order->invoice);
        }

        $invoice = Invoice::create([
            'invoice_number' => NumberGenerator::invoiceNumber(),
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'shipping_cost' => $order->shipping_cost,
            'total' => $order->total,
            'status' => $order->outstanding > 0 ? ($order->total_paid > 0 ? 'partial' : 'unpaid') : 'paid',
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice dibuat.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['order.items', 'order.payments', 'customer']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load(['order.items', 'order.payments', 'customer']);

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($invoice->invoice_number . '.pdf');
    }

    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.edit', compact('invoice'));
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());
        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice diperbarui.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice dihapus.');
    }
}