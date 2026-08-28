<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class ProductionController extends Controller
{
    public function index()
    {
        $columns = [
            'confirmed' => 'Confirmed',
            'design' => 'Design',
            'production' => 'Produksi',
            'quality_control' => 'QC',
            'ready_to_deliver' => 'Siap Kirim',
        ];

        $orders = Order::with('customer')
            ->whereIn('status', array_keys($columns))
            ->orderBy('deadline')
            ->get()
            ->groupBy('status');

        return view('admin.production.index', compact('orders', 'columns'));
    }
}