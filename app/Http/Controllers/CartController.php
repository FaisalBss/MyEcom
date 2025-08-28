<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    protected function key(): string
    {
        return 'cart_' . auth()->id();
    }

    public function add(Product $product, Request $request)
    {
        $qty   = max(1, (int) $request->input('qty', 1));
        $key   = $this->key();
        $cart  = session()->get($key, []);

        $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;

        session()->put($key, $cart);

        return back()->with('status', 'Added to cart!');
    }

    public function view()
    {
        $key   = $this->key();
        $cart  = session()->get($key, []); // [id => qty]

        $productIds = array_keys($cart);
        $items = collect();

        if (!empty($productIds)) {
            $products = Product::whereIn('id', $productIds)->get();
            $items = $products->map(function ($p) use ($cart) {
                $qty = (int) ($cart[$p->id] ?? 0);
                $subtotal = $qty * (float) $p->price;
                return (object)[
                    'id'        => $p->id,
                    'name'      => $p->name,
                    'price'     => (float) $p->price,
                    'quantity'  => $qty,
                    'image'     => $p->image,
                    'subtotal'  => $subtotal,
                ];
            });
        }

        $total = $items->sum('subtotal');

        return view('cart.index', compact('items', 'total'));
    }

    public function update(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('quantity', 1));

        $key  = $this->key();
        $cart = session()->get($key, []);

        if (isset($cart[$product->id])) {
            $cart[$product->id] = $qty;
            session()->put($key, $cart);
        }

        return back()->with('status', 'Quantity updated.');
    }

    public function remove(Product $product)
    {
        $key  = $this->key();
        $cart = session()->get($key, []);
        unset($cart[$product->id]);
        session()->put($key, $cart);

        return back()->with('status', 'Item removed.');
    }

    public function clear()
    {
        session()->forget($this->key());
        return back()->with('status', 'Cart cleared.');
    }

}
