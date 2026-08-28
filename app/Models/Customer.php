<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'organization', 'phone', 'email', 'address', 'notes'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getTotalOrdersAttribute(): int
    {
        return $this->orders()->count();
    }

    public function getTotalTransactionAttribute(): float
    {
        return (float) $this->orders()->sum('total');
    }

    public function getOutstandingAttribute(): float
    {
        $orders = $this->orders()->with('payments')->get();
        $total = $orders->sum('total');
        $paid = $orders->flatMap->payments->sum('amount');
        return max(0, $total - $paid);
    }
}
