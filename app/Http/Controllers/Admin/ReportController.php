<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $preset = $request->get('preset', 'this_month');
        $now = Carbon::now();
        switch ($preset) {
            case 'this_year':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                break;
            case 'custom':
                $start = $request->get('start') ? Carbon::parse($request->get('start')) : $now->copy()->startOfMonth();
                $end = $request->get('end') ? Carbon::parse($request->get('end')) : $now->copy()->endOfMonth();
                break;
            case 'this_month':
            default:
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                break;
        }

        // Revenue: only from non-cancelled orders
        $revenue = (float) Order::whereBetween('order_date', [$start, $end])
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');

        $payment = (float) Payment::whereBetween('payment_date', [$start, $end])->sum('amount');
        $expense = (float) Expense::whereBetween('date', [$start, $end])->sum('amount');

        // HPP: only from non-cancelled orders
        $hpp = (float) Order::whereBetween('order_date', [$start, $end])
            ->whereNotIn('status', ['cancelled'])
            ->with('items')
            ->get()
            ->sum(fn ($o) => $o->hpp_total);

        $grossProfit = $revenue - $hpp;
        $netProfit = $grossProfit - $expense;

        $orders = Order::with('customer')
            ->whereBetween('order_date', [$start, $end])
            ->whereNotIn('status', ['cancelled'])
            ->latest('order_date')
            ->limit(50)
            ->get();

        // Top customers: only from non-cancelled orders
        $topCustomers = Customer::withSum(['orders as total_orders_value' => fn ($q) => $q->whereBetween('order_date', [$start, $end])->whereNotIn('status', ['cancelled'])], 'total')
            ->orderByDesc('total_orders_value')
            ->limit(10)
            ->get();

        // Top products by order items (manual join)
        // Top products: only from non-cancelled orders
        $topProducts = \DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->whereBetween('orders.order_date', [$start, $end])
            ->whereNotIn('orders.status', ['cancelled'])
            ->selectRaw('products.id, products.name, SUM(order_items.quantity) as qty, SUM(order_items.subtotal) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('qty')
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact(
            'revenue', 'payment', 'expense', 'hpp', 'grossProfit', 'netProfit',
            'orders', 'topCustomers', 'topProducts',
            'start', 'end', 'preset'
        ));
    }
}
