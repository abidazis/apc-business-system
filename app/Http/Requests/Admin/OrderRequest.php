<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('Order.manage'); }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'lead_id' => ['nullable', 'exists:leads,id'],
            'order_date' => ['required', 'date'],
            'deadline' => ['nullable', 'date'],
            'status' => ['required', 'in:' . implode(',', array_keys(\App\Models\Order::STATUSES))],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'shipping_cost' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.hpp' => ['required', 'numeric', 'min:0'],
            'items.*.product_id' => ['nullable', 'exists:products,id'],
        ];
    }
}
