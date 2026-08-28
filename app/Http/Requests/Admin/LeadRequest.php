<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('Lead.manage'); }

    public function rules(): array
    {
        return [
            'contact_name' => ['required', 'string', 'max:120'],
            'organization' => ['nullable', 'string', 'max:160'],
            'phone' => ['nullable', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:160'],
            'source' => ['nullable', 'string', 'max:60'],
            'estimated_value' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:new,contacted,negotiation,quotation,won,lost'],
            'follow_up_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ];
    }
}
