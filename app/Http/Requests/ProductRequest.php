<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => 'required',
            'description' => 'required|max:255',
            'price' => 'required|numeric|min:1',
            'stock_quantity' => 'required|integer|min:1',

        ];
    }
    public function messages(): array
    {
        return [

            'name.required' => 'Product name is required',
            'description.required' => 'Description is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be greater than 0',
            'stock_quantity.required' => 'Stock is required',
            'stock_quantity.integer' => 'Stock must be an integer',
            'stock_quantity.min' => 'Stock must be greater than 0',
            'phone_number.required' => 'Phone number is required',
            'address.required' => 'Address is required',

        ];
    }
}
