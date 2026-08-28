<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('PortfolioProject.manage'); }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'customer_name' => ['nullable', 'string', 'max:160'],
            'project_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'products' => ['nullable', 'array'],
            'products.*' => ['exists:products,id'],
            'product_quantities' => ['nullable', 'array'],
            'product_quantities.*' => ['nullable', 'integer', 'min:1'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
            'sort_order' => (int) ($this->input('sort_order') ?: 0),
        ]);
    }
}