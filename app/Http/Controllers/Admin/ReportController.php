<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
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

        // Total expenses (all for cash flow / saldo)
        $totalExpense = (float) Expense::whereBetween('date', [$start, $end])->sum('amount');

        // Operational expenses only (for Net Profit calculation)
        $operationalCategoryIds = ExpenseCategory::where('is_operational', true)->pluck('id');
        $operationalExpense = (float) Expense::whereBetween('date', [$start, $end])
            ->whereIn('expense_category_id', $operationalCategoryIds)
            ->sum('amount');

        // HPP: only from non-cancelled orders
        $hpp = (float) Order::whereBetween('order_date', [$start, $end])
            ->whereNotIn('status', ['cancelled'])
            ->with('items')
            ->get()
            ->sum(fn ($o) => $o->hpp_total);

        $grossProfit = $revenue - $hpp;
        $netProfit = $grossProfit - $operationalExpense;
        $currentBalance = $payment - $totalExpense;

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

        // Daily Cash Flow: group payments and expenses by date
        $paymentsDaily = Payment::whereBetween('payment_date', [$start, $end])
            ->selectRaw('DATE(payment_date) as date, SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $expensesDaily = Expense::whereBetween('date', [$start, $end])
            ->selectRaw('DATE(date) as date, SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        // Build daily cash flow rows
        $cashFlow = [];
        $runningBalance = 0;
        $current = $start->copy();

        while ($current <= $end) {
            $dateKey = $current->format('Y-m-d');
            $income = (float) ($paymentsDaily[$dateKey] ?? 0);
            $exp = (float) ($expensesDaily[$dateKey] ?? 0);
            $runningBalance += $income - $exp;

            $cashFlow[] = [
                'date' => $current->copy(),
                'income' => $income,
                'expense' => $exp,
                'balance' => $runningBalance,
            ];

            $current->addDay();
        }

        return view('admin.reports.index', compact(
            'revenue', 'payment', 'totalExpense', 'operationalExpense', 'hpp', 'grossProfit', 'netProfit', 'currentBalance',
            'orders', 'topCustomers', 'topProducts',
            'start', 'end', 'preset', 'cashFlow'
        ));
    }
}
