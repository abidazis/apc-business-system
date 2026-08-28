<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('Product.manage');
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'sku' => ['nullable', 'string', 'max:60'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'specifications' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_type' => ['required', 'in:fixed,starting_from,contact'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_published' => $this->boolean('is_published'),
            'price' => $this->input('price') === '' ? null : $this->input('price'),
        ]);
    }
}
