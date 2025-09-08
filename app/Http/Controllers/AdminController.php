<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class AdminController extends Controller
{
    public function AdminProducts($catid = null){
        // $products = Product::where('category_id', $catid)->get();
        // return view('admin.product' , ['products' => $products] );

        $categories = Category::all();
    $products = Product::paginate(9);
    return view('admin.product' , ['products' => $products , 'categories' => $categories] );
    }
}
