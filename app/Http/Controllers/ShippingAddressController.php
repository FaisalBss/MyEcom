<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;

class ShippingAddressController extends Controller
{
    public function upsert(Request $request)
    {
        $data = $request->validate([
            'full_name'      => 'required|string|max:255',
            'address_line1'  => 'required|string|max:255',
            'address_line2'  => 'nullable|string|max:255',
            'city'           => 'required|string|max:120',
            'state'          => 'required|string|max:120',
            'zip'            => 'required|string|max:20',
            'country'        => 'required|string|max:120',
            'phone'          => 'required|string|max:30',
        ]);

        $data['user_id'] = auth()->id();

        if ($request->filled('address_id') && $request->address_id !== 'new') {
            // تعديل عنوان موجود
            ShippingAddress::where('user_id', auth()->id())
                ->where('id', $request->address_id)
                ->update($data);
        } else {
            // إضافة عنوان جديد
            ShippingAddress::create($data);
        }

        return back()->with('success', 'Shipping address saved.');
    }
}
