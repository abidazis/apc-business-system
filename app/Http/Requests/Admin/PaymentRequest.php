<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('Payment.manage'); }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'payment_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:1'],
            'method' => ['required', 'in:cash,bank_transfer,ewallet,other'],
            'reference' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string'],
        ];
    }
}