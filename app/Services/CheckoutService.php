<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function getCartSummary(int $userId): array
    {
        $items = Cart::with('product')->where('user_id', $userId)->get();
        $total = $items->sum(fn($i) => ($i->product->price ?? 0) * ($i->quantity ?? 1));
        $shipping = 0;

        return [$items, $total, $shipping];
    }

    public function placeOrder($user, array $validated): void
    {
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            throw new \Exception('Cart is empty.');
        }

        DB::transaction(function () use ($user, $cartItems, $validated) {
            $method = PaymentMethod::find($validated['payment_method_id']);

            $order = Order::create([
                'user_id'        => $user->id,
                'status'         => 'pending',
                'payment_method' => 'Card **** ' . $method->last4,
                'transaction_id' => uniqid('txn_'),
                'address_id'     => $validated['shipping_address_id'],
            ]);

            foreach ($cartItems as $item) {
                $qty = $item->quantity ?? 1;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $qty,
                    'price'      => $item->product->price ?? 0,
                ]);

                if (isset($item->product->stock)) {
                    $item->product->decrement('stock', $qty);
                } elseif (isset($item->product->quantity)) {
                    $item->product->decrement('quantity', $qty);
                }
            }

            $order->recalcTotal();

            Cart::where('user_id', $user->id)->delete();
        });
    }
}
