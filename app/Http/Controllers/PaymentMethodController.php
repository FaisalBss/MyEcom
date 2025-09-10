<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Requests\StorePaymentMethodRequest;

class PaymentMethodController extends Controller
{
    public function upsert(StorePaymentMethodRequest $request)
    {
        PaymentMethod::updateOrCreate(
            ['user_id' => auth()->id(), 'id' => $request->input('payment_method_id')],
            [
                'cardholder_name' => $request->card_name,
                'last4'           => substr($request->card_number, -4),
                'brand'           => 'Card',
                'exp_month'       => explode('/', $request->expiry_date)[0],
                'exp_year'        => '20'.explode('/', $request->expiry_date)[1],
            ]
        );

        return back()->with('success', 'Payment method saved successfully.');
    }

}
