<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;

class FirstController extends Controller
{
    public function MainPage() {

    $result = Category::all();
    return view('welcome', ['categories' => $result]);


}

public function  GetCategoryProduct($catid = null) {

    if($catid == null) {
        $products = Product::all();
         return view('product' , ['products' => $products] );
    } else{
    $products = Product::where('category_id', $catid)->get();
    return view('product' , ['products' => $products] );
    }
}

public function  GetAllCategoryWithProduct() {

    $categories = Category::all();
    $products = Product::all();
    return view('category' , ['products' => $products , 'categories' => $categories] );
}


}
