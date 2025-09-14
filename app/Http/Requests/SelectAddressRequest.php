<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelectAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'shipping_address_id' => ['required','exists:shipping_addresses,id'],
        ];
    }

     public function messages(): array
    {
        return [
            'shipping_address_id.required' => 'Please select a shipping address before proceeding.',
            'shipping_address_id.exists'   => 'The selected address is invalid.',
        ];
    }
}
