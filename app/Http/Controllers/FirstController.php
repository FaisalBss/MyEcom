<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;


class FirstController extends Controller
{
    public function MainPage() {

    $result = Category::all();
    return view('welcome', ['categories' => $result]);


}

    public function NotFoundPage() {
        return view('404');
    }

public function  GetCategoryProduct($catid = null) {

    if($catid == null) {
        $products = Product::paginate(9);
         ;
    } else{
    $products = Product::where('category_id', $catid)->paginate(9);
    }
    return view('product' , ['products' => $products]);
}

public function  GetAllCategoryWithProduct() {

    $categories = Category::all();
    $products = Product::paginate(10);
    return view('category' , ['products' => $products , 'categories' => $categories] );
}

public function SearchProducts(Request $request) {
    $searchKey = $request->input('searchKey');

    $products = Product::where('name', 'LIKE', '%' . $searchKey . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchKey . '%')
                        ->paginate(9);

    return view('product', ['products' => $products]);
}

public function myOrders(Request $request)
    {
        $user = $request->user();

        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->paginate(10);

        return view('orders.my_orders', compact('orders'));
    }

public function AdminDashboard() {
    return view('admin.dashboard');
}

}
