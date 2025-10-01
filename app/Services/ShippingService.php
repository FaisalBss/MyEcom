<?php

namespace App\Services;

use App\Models\ShippingAddress;

class ShippingService
{
    public function getUserAddresses(int $userId)
    {
        return ShippingAddress::where('user_id', $userId)->get();
    }

    public function storeAddress(int $userId, array $data)
    {
        return ShippingAddress::create(array_merge($data, ['user_id' => $userId]));
    }
}
