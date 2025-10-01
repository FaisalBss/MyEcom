<?php

namespace App\Services;

use App\Models\PaymentMethod;

class PaymentService
{
    public function getUserMethods(int $userId)
    {
        return PaymentMethod::where('user_id', $userId)->get();
    }

    public function saveCard(int $userId, array $validated)
    {
        $digits = preg_replace('/\D/', '', $validated['card_number']);
        $last4  = substr($digits, -4);

        return PaymentMethod::create([
            'user_id'          => $userId,
            'cardholder_name'  => $validated['card_name'],
            'last4'            => $last4,
            'exp_month'        => $validated['exp_month'],
            'exp_year'         => $validated['exp_year'],
        ]);
    }
}
