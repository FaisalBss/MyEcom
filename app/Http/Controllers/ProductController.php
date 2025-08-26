<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function AddProduct() {

        $allCategories = Category::all();
        return view('Products.addproduct', ['categories' => $allCategories]);
    }

    public function StoreProduct(Request $request){

        $request->validate([
            'name' => 'unique:products|required|min:3|max:20|regex:/^[a-zA-Z0-9\s]+$/',
            'price' => 'required|decimal:0,2',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'category' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $newproduct = new Product();
        $newproduct->name = $request->name;
        $newproduct->price = $request->price;
        $newproduct->quantity = $request->quantity;
        $newproduct->description = $request->description;
        $newproduct->image = 'noimage.png';
        $newproduct->category_id = 1;
        $newproduct->save();

        return redirect('/');
    }
}
