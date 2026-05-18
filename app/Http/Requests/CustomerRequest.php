<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'email' => 'required|email',
            'phone_number' => 'required',
            'address' => 'required',

        ];
    }
    public function messages(): array
    {
        return [

            'name.required' => 'Customer name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email address',
            'phone_number.required' => 'Phone number is required',
            'address.required' => 'Address is required',

        ];
    }
}
