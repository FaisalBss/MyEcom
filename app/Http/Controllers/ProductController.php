<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function AddProduct() {

        $allCategories = Category::all();
        return view('Products.addproduct', ['categories' => $allCategories]);
    }

    public function StoreProduct(Request $request)
{
    $request->validate([
        'name'        => 'required|min:3|max:20',
        'price'       => 'required|numeric',
        'quantity'    => 'required|integer',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
    ]);

    $uploadsPath = public_path('uploads');
    if (!File::exists($uploadsPath)) {
        File::makeDirectory($uploadsPath, 0755, true);
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move($uploadsPath, $imageName);
        $imagePath = 'uploads/' . $imageName;
    }

    $product = new \App\Models\Product();
    $product->name        = $request->name;
    $product->price       = $request->price;
    $product->quantity    = $request->quantity;
    $product->category_id = $request->category_id;
    $product->description = $request->description;
    $product->image       = $imagePath;
    $product->save();

    return redirect(route('admin.dashboard'))->with('status', 'Product created successfully!');
}

    public function DeleteProduct($productid = null) {
        if ($productid) {
            $product = Product::find($productid);

            if ($product && $product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();
        }
        return redirect()->back();
    }

    public function EditProduct($productid){
    $product = Product::findOrFail($productid);
    $categories = Category::all();

    return view('Products.editproduct', compact('product', 'categories'));
}

    public function UpdateProduct(Request $request, $productid)
    {
        $request->validate([
            'name' => 'required|min:3|max:20',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpg,png,img,jpeg|max:4800',
        ]);

        $product = Product::findOrFail($productid);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);

            $product->image = 'uploads/' . $imageName;
        }

    $product->save();

    return redirect(route('admin.dashboard'))->with('status', 'Product updated successfully!');
}


}
