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



}
