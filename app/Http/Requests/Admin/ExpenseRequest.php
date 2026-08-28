<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('Expense.manage'); }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'expense_category_id' => ['nullable', 'exists:expense_categories,id'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['required', 'in:cash,bank_transfer,ewallet,other'],
            'reference' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string'],
        ];
    }
}