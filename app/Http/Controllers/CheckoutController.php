<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Http\Requests\ShippingRequest;
use App\Http\Requests\SelectAddressRequest;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PlaceOrderRequest;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $items = Cart::with('product')->where('user_id', $request->user()->id)->get();
        $total = $items->sum(fn($i) => ($i->product->price ?? 0) * ($i->quantity ?? 1));
        $shipping = 0;

        return view('cart.index', compact('items', 'total', 'shipping'));
    }

    public function shipping(Request $request)
    {
        $addresses = ShippingAddress::where('user_id', $request->user()->id)->get();
        return view('cart.checkout.shipping', compact('addresses'));
    }

    public function storeShipping(ShippingRequest $request)
    {
        $validated = $request->validated();
        $request->user()->shippingAddresses()->create($validated);

        return back()->with('status', 'Address saved successfully.');
    }

    public function selectShipping(SelectAddressRequest $request)
    {
        return redirect()->route('checkout.payment', [
            'shipping_address_id' => $request->shipping_address_id
        ]);
    }

    public function payment(Request $request)
    {
        $methods = PaymentMethod::where('user_id', $request->user()->id)->get();
        return view('cart.checkout.payment', compact('methods'));
    }

    public function savePaymentMethod(PaymentRequest $request)
    {
        $validated = $request->validated();

        $digits = preg_replace('/\D/', '', $validated['card_number']);
        $last4  = substr($digits, -4);

        PaymentMethod::create([
            'user_id'          => $request->user()->id,
            'cardholder_name'  => $validated['card_name'],
            'last4'            => $last4,
            'exp_month'        => $validated['exp_month'],
            'exp_year'         => $validated['exp_year'],
        ]);

        return back()->with('status', 'Card saved successfully.');
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        try {
            DB::transaction(function () use ($user, $cartItems, $validated, $request) {
                $method = PaymentMethod::find($validated['payment_method_id']);
                $order = Order::create([
                    'user_id'        => $user->id,
                    'status'         => 'pending',
                    'payment_method' => 'Card **** ' . $method->last4,
                    'transaction_id' => uniqid('txn_'),
                    'address_id'     => $request->input('shipping_address_id'),
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

            return redirect()->route('user.Orders')->with('status', 'Order placed successfully.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }
}
