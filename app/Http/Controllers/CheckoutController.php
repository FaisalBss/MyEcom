<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        return redirect()->route('orders.index')
            ->with('status', 'Order placed successfully!');
    }

    public function myOrders()
    {
        $orders = collect();
        return view('orders.index', compact('orders'));
    }
$tax      = round($total * 0.15, 2);
$shipping = (strcasecmp(session('coupon'), 'Aseel') === 0) ? 0.0 : 20.0;
$grand    = round($total + $tax + $shipping, 2);

$order->update(['total' => $grand, 'status' => 'paid']);

session()->forget('coupon');

}
