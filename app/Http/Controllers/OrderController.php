<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function UserOrders(Request $request)
    {
        $user = $request->user();

        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->paginate(10);

        return view('orders', compact('orders'));
    }
}
