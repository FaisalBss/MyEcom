<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function upsert(Request $request)
    {
        if ($request->filled('payment_method_id') && !$request->filled('card_number')) {
            PaymentMethod::where('user_id', auth()->id())->update(['is_default' => false]);
            PaymentMethod::where('user_id', auth()->id())
                ->where('id', $request->payment_method_id)
                ->update(['is_default' => true]);

            return back()->with('success', 'Payment method selected.');
        }

        $pan = preg_replace('/\D/', '', (string) $request->input('card_number', ''));
        $request->merge(['card_number' => $pan]);

        $validated = $request->validate([
            'card_name'   => ['required','string','max:255'],
            'card_number' => ['required','string','regex:/^\d{13,19}$/'],
            'expiry_date' => ['required','string','regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'cvv'         => ['required','string','regex:/^\d{3,4}$/'],
        ]);

        $last4 = substr($validated['card_number'], -4);
        [$mm, $yy] = explode('/', $validated['expiry_date']);
        $expMonth = (int) $mm;
        $expYear  = (int) ('20' . $yy);

        $brand = 'Card';
        if (str_starts_with($validated['card_number'], '4')) {
            $brand = 'Visa';
        } elseif (preg_match('/^5[1-5]/', $validated['card_number'])) {
            $brand = 'MasterCard';
        } elseif (preg_match('/^(50|56|57|58|63|67)/', $validated['card_number'])) {
            $brand = 'Mada';
        }

        PaymentMethod::where('user_id', auth()->id())->update(['is_default' => false]);

        PaymentMethod::updateOrCreate(
            [
                'user_id'   => auth()->id(),
                'last4'     => $last4,
                'exp_month' => $expMonth,
                'exp_year'  => $expYear,
            ],
            [
                'cardholder_name' => $validated['card_name'],
                'brand'           => $brand,
                'gateway'         => null,
                'token'           => null,
                'is_default'      => true,
            ]
        );

        return back()->with('success', 'Payment method saved.');
    }
}
