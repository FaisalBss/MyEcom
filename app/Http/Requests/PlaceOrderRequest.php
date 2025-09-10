<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\ShippingAddress;

class PlaceOrderRequest extends FormRequest
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
            'payment_method_id' => ['required','exists:payment_methods,id'],
            'cvv'               => ['required','digits_between:3,4'],
        ];

    }

    public function messages(): array
    {
        return [
            'payment_method_id.required' => 'Please select a card.',
            'cvv.required'               => 'CVV is required.',
            'cvv.digits_between'         => 'CVV must be 3 or 4 digits.',
        ];
    }
}
