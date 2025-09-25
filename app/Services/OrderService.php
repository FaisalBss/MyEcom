<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function getAllOrders()
    {
        return Order::with(['user', 'items.product'])->paginate(10);
    }

    public function updateStatus(int $id, string $status): Order
    {
        $order = Order::findOrFail($id);
        $order->status = $status;
        $order->save();

        return $order;
    }

    public function searchOrders(?string $search)
    {
        return Order::with(['user', 'items.product'])
            ->when($search, function ($query, $search) {
                $query->where('id', $search)
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('items.product', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]);
    }
}
