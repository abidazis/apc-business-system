<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUSES = [
        'lead' => 'Lead',
        'quotation' => 'Quotation',
        'confirmed' => 'Confirmed',
        'dp_received' => 'DP Diterima',
        'design' => 'Desain',
        'production' => 'Produksi',
        'quality_control' => 'Quality Control',
        'ready_to_deliver' => 'Siap Kirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    public const PRODUCTION_STATUSES = [
        'confirmed', 'design', 'production', 'quality_control', 'ready_to_deliver',
    ];

    /**
     * Valid status transitions.
     * Key = current status, Value = array of allowed next statuses.
     */
    public const STATUS_TRANSITIONS = [
        'lead' => ['quotation', 'cancelled'],
        'quotation' => ['confirmed', 'cancelled'],
        'confirmed' => ['dp_received', 'cancelled'],
        'dp_received' => ['design', 'cancelled'],
        'design' => ['production', 'cancelled'],
        'production' => ['quality_control', 'cancelled'],
        'quality_control' => ['ready_to_deliver', 'production', 'cancelled'],
        'ready_to_deliver' => ['completed', 'cancelled'],
        'completed' => [], // Final state
        'cancelled' => [], // Final state
    ];

    public function canTransitionTo(string $newStatus): bool
    {
        $allowed = self::STATUS_TRANSITIONS[$this->status] ?? [];

        return in_array($newStatus, $allowed, true);
    }

    public function getNextPossibleStatuses(): array
    {
        return self::STATUS_TRANSITIONS[$this->status] ?? [];
    }

    protected $fillable = [
        'order_number', 'customer_id', 'lead_id', 'order_date', 'deadline',
        'status', 'subtotal', 'discount', 'shipping_cost', 'total', 'notes',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'deadline' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recalculateTotals(): void
    {
        $subtotal = (float) $this->items()->sum('subtotal');
        $discount = (float) $this->discount;
        $shipping = (float) $this->shipping_cost;
        $this->subtotal = $subtotal;
        $this->total = max(0, $subtotal - $discount + $shipping);
        $this->saveQuietly();
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getOutstandingAttribute(): float
    {
        return max(0, (float) $this->total - $this->total_paid);
    }

    public function getPaymentStatusAttribute(): string
    {
        if ($this->total_paid <= 0) {
            return 'unpaid';
        }
        if ($this->outstanding > 0) {
            return 'partial';
        }

        return 'paid';
    }

    public function getHppTotalAttribute(): float
    {
        return (float) $this->items()->sum(\DB::raw('quantity * hpp'));
    }

    public function getGrossProfitAttribute(): float
    {
        return (float) $this->total - $this->hpp_total;
    }

    public function isOverdue(): bool
    {
        return $this->deadline && $this->deadline->isPast() && ! in_array($this->status, ['completed', 'cancelled'], true);
    }

    public function isDeadlineNear(int $days = 3): bool
    {
        return $this->deadline
            && ! in_array($this->status, ['completed', 'cancelled'], true)
            && $this->deadline->diffInDays(now(), false) <= -($days - 1);
    }
}
