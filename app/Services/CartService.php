<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public function getUserCart(int $userId): array
    {
        $items = Cart::where('user_id', $userId)
            ->with('product')
            ->latest()
            ->get();

        $total = $items->sum(fn($r) => (float)$r->product->price * (int)$r->quantity);

        return [$items, $total];
    }

    public function addToCart(int $userId, Product $product, $request): string
    {
        $qty = (int) ($request->input('qty') ?? $request->input('quantity') ?? 1);
        $qty = max(1, $qty);

        if ($product->quantity !== null && $product->quantity < $qty) {
            return 'Product stock is not enough for the requested quantity.';
        }

        $row = Cart::firstOrCreate(
            ['user_id' => $userId, 'product_id' => $product->id],
            ['quantity' => 0]
        );

        $row->increment('quantity', $qty);

        return 'Added to cart.';
    }

    public function updateCart(int $userId, Product $product, int $qty): string
    {
        $row = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if (!$row) {
            return 'Product not found in your cart.';
        }

        if ($product->quantity !== null && $product->quantity < $qty) {
            return 'Not enough stock for the requested quantity.';
        }

        $row->update(['quantity' => $qty]);

        return 'Updated successfully.';
    }

    public function removeFromCart(int $userId, Product $product): string
    {
        $deleted = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->delete();

        return $deleted ? 'Product was deleted.' : 'Product not found in your cart.';
    }

    public function clearCart(int $userId): void
    {
        Cart::where('user_id', $userId)->delete();
    }
}
