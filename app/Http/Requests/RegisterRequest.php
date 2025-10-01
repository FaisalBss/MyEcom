<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'     => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|max:15|confirmed',
        ];
    }

     public function messages(): array
    {
        return [
            'name.regex' => 'Name must contain only English letters.',
        ];
    }
}
