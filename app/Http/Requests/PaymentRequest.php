<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'card_name'   => ['required','string','max:255','regex:/^[\p{Arabic}a-zA-Z\s]+$/u'],
            'card_number' => ['required','regex:/^(\d{4}\s?){3}\d{4}$/'],
            'exp_month'   => ['required','integer','min:1','max:12'],
            'exp_year'    => ['required','integer','min:' . date('Y'), 'max:' . (date('Y')+20)],

        ];
    }

    public function messages(): array
    {
        return [
            'card_name.regex'   => 'Cardholder name must contain only letters and spaces.',
            'card_number.regex' => 'Card number must be 13–19 digits.',
            'exp_month.*'       => 'Expiry month must be between 1 and 12.',
            'exp_year.*'        => 'Expiry year must be valid.',
            'cvv.digits_between'=> 'CVV must be 3 or 4 digits.',
        ];
    }
}
