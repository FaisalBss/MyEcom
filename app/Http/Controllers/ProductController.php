<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function AddProduct() {

        return view('Products.addproduct');
    }

    public function StoreProduct(Request $request){

        $request->validate([
            'name' => 'required|min:3|max:20',
            'price' => 'required|decimal:0,2',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
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
