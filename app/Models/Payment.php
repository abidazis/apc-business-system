<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const METHODS = ['cash' => 'Tunai', 'bank_transfer' => 'Transfer Bank', 'ewallet' => 'E-Wallet', 'other' => 'Lainnya'];

    protected $fillable = [
        'order_id', 'payment_date', 'amount', 'method',
        'reference', 'notes', 'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
