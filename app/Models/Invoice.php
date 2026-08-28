<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUSES = ['unpaid' => 'Belum Dibayar', 'partial' => 'Sebagian', 'paid' => 'Lunas'];

    protected $fillable = [
        'invoice_number', 'order_id', 'customer_id', 'issue_date',
        'due_date', 'subtotal', 'discount', 'shipping_cost', 'total',
        'status', 'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
