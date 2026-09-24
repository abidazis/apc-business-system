<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('admin.access');
        [$start, $end, $preset] = $this->resolveRange($request);

        // Omzet: only active orders (not cancelled)
        $ordersInRange = Order::whereBetween('order_date', [$start, $end])
            ->whereNotIn('status', ['cancelled']);
        $omzet = (clone $ordersInRange)->sum('total');

        $paymentIn = (float) Payment::whereBetween('payment_date', [$start, $end])->sum('amount');
        $expenseIn = (float) Expense::whereBetween('date', [$start, $end])->sum('amount');

        // HPP: only from non-cancelled orders
        $hpp = (float) Order::whereBetween('order_date', [$start, $end])
            ->whereNotIn('status', ['cancelled'])
            ->with('items')
            ->get()
            ->sum(fn ($o) => $o->hpp_total);

        $grossProfit = (float) $omzet - $hpp;
        $netProfit = $grossProfit - $expenseIn;

        // Piutang: only from active orders (not completed, not cancelled)
        $piutang = (float) Order::whereIn('status', ['confirmed', 'dp_received', 'design', 'production', 'quality_control', 'ready_to_deliver'])
            ->get()
            ->sum(fn ($o) => $o->outstanding);

        $orderCount = (clone $ordersInRange)->count();
        $completedCount = (clone $ordersInRange)->where('status', 'completed')->count();

        $overdueOrders = Order::whereNotIn('status', ['completed', 'cancelled'])
            ->where('deadline', '<', Carbon::today())
            ->with('customer')
            ->orderBy('deadline')
            ->limit(10)
            ->get();

        $deadlineNear = Order::whereNotIn('status', ['completed', 'cancelled'])
            ->whereBetween('deadline', [Carbon::today(), Carbon::today()->addDays(3)])
            ->with('customer')
            ->orderBy('deadline')
            ->limit(10)
            ->get();

        $needsAttention = Order::whereNotIn('status', ['completed', 'cancelled'])
            ->where(function ($q) {
                $q->where('deadline', '<', Carbon::today())
                    ->orWhereBetween('deadline', [Carbon::today(), Carbon::today()->addDays(3)]);
            })
            ->orWhere(function ($q) {
                $q->whereNotIn('status', ['completed', 'cancelled'])
                    ->whereDoesntHave('payments');
            })
            ->with('customer')
            ->orderBy('deadline')
            ->limit(20)
            ->get();

        // Production overview — counts per stage
        $productionCounts = Order::whereIn('status', Order::PRODUCTION_STATUSES)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $productionStages = Order::PRODUCTION_STATUSES;
        $productionTotal = array_sum($productionCounts);

        // Recent activity
        $recentActivity = ActivityLog::with('user')
            ->latest('created_at')
            ->limit(15)
            ->get();

        return view('admin.dashboard.index', compact(
            'omzet', 'paymentIn', 'expenseIn', 'hpp', 'grossProfit', 'netProfit',
            'piutang', 'orderCount', 'completedCount',
            'overdueOrders', 'deadlineNear', 'needsAttention',
            'productionCounts', 'productionStages', 'productionTotal',
            'recentActivity',
            'start', 'end', 'preset'
        ));
    }

    private function resolveRange(Request $request): array
    {
        $preset = $request->get('preset', 'this_month');
        $now = Carbon::now();
        switch ($preset) {
            case 'today':
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
                break;
            case 'this_week':
                $start = $now->copy()->startOfWeek();
                $end = $now->copy()->endOfWeek();
                break;
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

        return [$start, $end, $preset];
    }
}
