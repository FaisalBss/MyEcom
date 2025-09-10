<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
class AdminController extends Controller
{
    public function AdminProducts($catid = null){

    $categories = Category::all();
    $products = Product::paginate(9);
    return view('admin.product' , ['products' => $products , 'categories' => $categories] );
    }

    public function index()
    {
        $orders = Order::with(['user', 'items.product'])->paginate(10);
        return view('admin.user_orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,on_the_way,delivered,canceled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function searchOrders(Request $request)
{
    $search = $request->input('search');

    $orders = Order::with(['user', 'items.product'])
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
        ->paginate(10)->appends(['search' => $search]); ;

    return view('admin.user_orders', compact('orders', 'search'));
}


}
