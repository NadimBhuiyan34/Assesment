<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:products,slug',
            'description'      => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'discount_price'   => 'nullable|numeric|min:0|lt:price',
            'stock'            => 'required|integer|min:0',
            'is_featured'      => 'boolean',
            'is_active'        => 'boolean',
            'weight'           => 'nullable|numeric|min:0',
            'length'           => 'nullable|numeric|min:0',
            'width'            => 'nullable|numeric|min:0',
            'height'           => 'nullable|numeric|min:0',
            'category_id'      => 'required|uuid|exists:categories,id',
            'brand_id'         => 'nullable|uuid|exists:brands,id',
            'shop_id'          => 'nullable|uuid|exists:shops,id',
            'tags'             => 'nullable|string',
            'specifications'   => 'nullable|json',
            'status'           => 'boolean',
        ];
    }
}
