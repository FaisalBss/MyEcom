<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Schema;


class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        $items = auth()->user()
            ->carts()
            ->with('product')
            ->latest()
            ->get();

        $total = $items->sum(fn($r) => (float)$r->product->price * (int)$r->quantity);

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Product $product, Request $request)
    {
        $qty = (int) ($request->input('qty') ?? $request->input('quantity') ?? 1);
        $qty = max(1, $qty);

        if (isset($product->quantity) && $product->quantity < $qty) {
            return back()->with('status', 'Product stock is not enough for the requested quantity.');
        }

        $row = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['quantity' => 0]
        );
        $row->increment('quantity', $qty);

        return back()->with('status', 'added to cart');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $qty = (int) $request->quantity;

        $row = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if (!$row) {
            return back()->with('status', 'Product not found in your cart.');
        }

        if (isset($product->quantity) && $product->quantity < $qty) {
            return back()->with('status', 'not enough stock for the requested quantity.');
        }

        $row->update(['quantity' => $qty]);

        return back()->with('status', 'Updated successfully.');
    }

    public function remove(Product $product)
    {
        $deleted = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('status', $deleted ? 'product was deleted' : 'Product not found in your cart.');
    }

    public function clear()
    {
        auth()->user()->carts()->delete();
        return back()->with('status', 'cart cleared');
    }

    public function checkout()
    {
        $items = auth()->user()
        ->carts()
        ->with('product')
        ->get();

    $total = $items->sum(fn($r) => (float)$r->product->price * (int)$r->quantity);

    return view('cart.CheckOut', compact('items', 'total'));
    }

   public function placeOrder(Request $request)
{
    $user = $request->user();

    $items = Cart::with('product')->where('user_id', $user->id)->get();
    if ($items->isEmpty()) {
        return back()->with('error', 'Cart is empty.');
    }

    $pmId = $request->input('payment_method_id');
    if ($pmId && ! PaymentMethod::where('user_id', $user->id)->where('id', $pmId)->exists()) {
        return back()->with('error', 'the payment method is invalid.');
    }

    $addrId = $request->input('address_id');
    if (! $addrId || ! ShippingAddress::where('user_id', $user->id)->where('id', $addrId)->exists()) {
        return back()->with('error', 'Choose shipping address.');
    }

    try {
        DB::beginTransaction();

        $subtotal = 0;

        $stockColumn = \Illuminate\Support\Facades\Schema::hasColumn('products', 'quantity') ? 'quantity'
                     : (\Illuminate\Support\Facades\Schema::hasColumn('products', 'stock') ? 'stock' : null);

        if (!$stockColumn) {
            throw new \Exception('not found stock column in products table.');
        }

        foreach ($items as $it) {
            $p = $it->product;
            if (!$p) {
                throw new \Exception('product not found in cart.');
            }

            $price = (float) $p->price;
            $qty   = (int) $it->quantity;
            $subtotal += $price * $qty;

            $affected = Product::whereKey($p->id)
                ->where($stockColumn, '>=', $qty)
                ->decrement($stockColumn, $qty);

            if ($affected === 0) {
                throw new \Exception("Not enough quantity {$p->name}");
            }
        }

        $shippingFee = 0;
        $total       = $subtotal + $shippingFee;

        $data = [
            'user_id' => $user->id,
            'status'  => 'pending',
        ];

        $amountColumn = \Illuminate\Support\Facades\Schema::hasColumn('orders', 'total') ? 'total'
                        : (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'total_amount') ? 'total_amount' : null);
        if (!$amountColumn) {
            throw new \Exception('not found total column in orders table.');
        }
        $data[$amountColumn] = $total;

        if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'payment_method')) {
            $pmSummary = null;
            if ($pmId) {
                $pm = PaymentMethod::where('user_id', $user->id)->find($pmId);
                if ($pm) {
                    $pmSummary = trim(($pm->brand ?? 'Card') . ' **** ' . $pm->last4);
                }
            }
            $data['payment_method'] = $pmSummary;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'transaction_id')) {
            $data['transaction_id'] = null;
        }

        $order = Order::create($data);

        foreach ($items as $it) {
            $p = $it->product;
            $price = (float) $p->price;
            $qty   = (int) $it->quantity;

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $p->id,
                'quantity'   => $qty,
                'price'      => $price,
            ]);
        }

        Cart::where('user_id', $user->id)->delete();

        DB::commit();

        session()->forget('checkout_allowed');

        return redirect()
            ->route('mainpage')
            ->with('success', "Your order has been created successfully#{$order->id} بنجاح.");
    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->with('error', 'Faild to create an order ' . $e->getMessage());
    }
}

}
