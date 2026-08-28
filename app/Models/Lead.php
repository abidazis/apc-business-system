<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_name', 'organization', 'phone', 'email', 'source',
        'estimated_value', 'status', 'follow_up_date', 'notes',
        'customer_id', 'assigned_to',
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'follow_up_date' => 'date',
    ];

    public const STATUSES = ['new', 'contacted', 'negotiation', 'quotation', 'won', 'lost'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
