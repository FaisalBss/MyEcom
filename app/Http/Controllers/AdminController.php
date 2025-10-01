<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderStatusRequest;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}

    /**
     * عرض المنتجات مع التصنيفات
     */
    public function AdminProducts(?int $catid = null)
    {
        $categories = $this->categoryService->getAll();
        $products   = $this->productService->getPaginated(9);

        return view('admin.product', compact('products', 'categories'));
    }

    /**
     * عرض جميع الطلبات
     */
    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('admin.user_orders', compact('orders'));
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateStatus(UpdateOrderStatusRequest $request, int $id)
    {
        $this->orderService->updateStatus($id, $request->validated()['status']);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * البحث عن الطلبات
     */
    public function searchOrders(Request $request)
    {
        $search = $request->input('search');
        $orders = $this->orderService->searchOrders($search);

        return view('admin.user_orders', compact('orders', 'search'));
    }
}
