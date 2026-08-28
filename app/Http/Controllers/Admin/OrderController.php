<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\NumberGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('customer')
            ->when($request->get('q'), fn ($q, $term) =>
                $q->where('order_number', 'like', "%{$term}%")
                  ->orWhereHas('customer', fn ($qq) => $qq->where('name', 'like', "%{$term}%")))
            ->when($request->get('status'), fn ($q, $s) => $q->where('status', $s))
            ->when($request->get('customer'), fn ($q, $id) => $q->where('customer_id', $id))
            ->latest('order_date')
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $customers = Customer::orderBy('name')->get();
        $leads = Lead::whereNotIn('status', ['won', 'lost'])->latest()->limit(50)->get();
        $lead = $request->filled('lead') ? Lead::find($request->lead) : null;
        return view('admin.orders.create', compact('customers', 'leads', 'lead'));
    }

    public function store(OrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['order_number'] = NumberGenerator::orderNumber();
            $data['created_by'] = $request->user()->id;

            $order = Order::create(collect($data)->except('items')->toArray());

            foreach ($data['items'] as $item) {
                $order->items()->create($item);
            }

            $order->recalculateTotals();

            // If linked to a lead, mark as won
            if ($order->lead_id) {
                Lead::where('id', $order->lead_id)->update(['status' => 'won']);
            }

            return redirect()->route('admin.orders.show', $order)->with('success', 'Order dibuat.');
        });
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items', 'payments', 'invoice', 'lead']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::orderBy('name')->get();
        $order->load('items');
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        return DB::transaction(function () use ($request, $order) {
            $data = $request->validated();
            $data['updated_by'] = $request->user()->id;

            $order->update(collect($data)->except('items')->toArray());

            // Simple replace strategy: delete & recreate. Items are not heavily relational.
            $order->items()->delete();
            foreach ($data['items'] as $item) {
                $order->items()->create($item);
            }
            $order->recalculateTotals();

            return redirect()->route('admin.orders.show', $order)->with('success', 'Order diperbarui.');
        });
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order dihapus.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys(Order::STATUSES))],
        ]);
        $order->update(['status' => $data['status'], 'updated_by' => $request->user()->id]);
        return back()->with('success', 'Status order diperbarui.');
    }
}
