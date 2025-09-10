<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
            'full_name'     => ['required','string','max:255','regex:/^[\p{Arabic}a-zA-Z\s]+$/u'],
            'address_line1' => ['required','string','max:255','regex:/^[\p{Arabic}a-zA-Z0-9\s]+$/u'],
            'address_line2' => ['nullable','string','max:255','regex:/^[\p{Arabic}a-zA-Z0-9\s]*$/u'],
            'city'          => ['required','string','max:255','regex:/^[\p{Arabic}a-zA-Z0-9\s]+$/u'],
            'state'         => ['required','string','max:255','regex:/^[\p{Arabic}a-zA-Z0-9\s]+$/u'],
            'zip'           => ['required','regex:/^[0-9]+$/'],
            'country'       => ['required','string','max:255','regex:/^[\p{Arabic}a-zA-Z0-9\s]+$/u'],
            'phone'         => ['required','regex:/^\+?[0-9]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.regex'      => 'Full name: letters and spaces only.',
            'address_line1.regex'  => 'Address line 1: letters, numbers, and spaces only.',
            'address_line2.regex'  => 'Address line 2: letters, numbers, and spaces only.',
            'city.regex'           => 'City: letters, numbers, and spaces only.',
            'state.regex'          => 'State: letters, numbers, and spaces only.',
            'country.regex'        => 'Country: letters, numbers, and spaces only.',
            'zip.regex'            => 'ZIP must contain digits only.',
            'phone.regex'          => 'Phone must be digits with an optional leading +.',
        ];
    }
}
