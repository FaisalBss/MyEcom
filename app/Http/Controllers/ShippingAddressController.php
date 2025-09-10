<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Http\Requests\StoreShippingAddressRequest;

class ShippingAddressController extends Controller
{
    public function upsert(StoreShippingAddressRequest $request)
    {
        ShippingAddress::updateOrCreate(
            ['user_id' => auth()->id(), 'id' => $request->input('address_id')],
            $request->validated() + ['user_id' => auth()->id()]
        );

        return back()->with('success', 'Shipping address saved successfully.');
    }
}
