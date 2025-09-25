<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Services\OrderService;

class AdminController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function AdminProducts($catid = null)
    {
        $categories = Category::all();
        $products = Product::paginate(9);

        return view('admin.product', compact('products', 'categories'));
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('admin.user_orders', compact('orders'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, $id)
    {
        $this->orderService->updateStatus($id, $request->validated()['status']);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function searchOrders()
    {
        $search = request('search');
        $orders = $this->orderService->searchOrders($search);

        return view('admin.user_orders', compact('orders', 'search'));
    }
}
