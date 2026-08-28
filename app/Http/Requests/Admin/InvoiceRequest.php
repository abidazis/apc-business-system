<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('Invoice.manage'); }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}