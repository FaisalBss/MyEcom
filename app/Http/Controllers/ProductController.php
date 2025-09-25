<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function AddProduct()
    {
        $allCategories = Category::all();
        return view('Products.addproduct', ['categories' => $allCategories]);
    }

    public function StoreProduct(StoreProductRequest $request)
    {
        $validated = $request->validated();

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

        $product = new Product();
        $product->name        = $validated['name'];
        $product->price       = $validated['price'];
        $product->quantity    = $validated['quantity'];
        $product->category_id = $validated['category_id'];
        $product->description = $validated['description'] ?? null;
        $product->image       = $imagePath;
        $product->save();

        return redirect(route('admin.dashboard'))->with('status', 'Product created successfully!');
    }

    public function DeleteProduct($productid = null)
    {
        if ($productid) {
            $product = Product::find($productid);

            if ($product && $product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();
        }
        return redirect()->back();
    }

    public function EditProduct($productid)
    {
        $product = Product::findOrFail($productid);
        $categories = Category::all();

        return view('Products.editproduct', compact('product', 'categories'));
    }

    public function UpdateProduct(UpdateProductRequest $request, $productid)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($productid);
        $product->name        = $validated['name'];
        $product->price       = $validated['price'];
        $product->quantity    = $validated['quantity'];
        $product->description = $validated['description'] ?? null;
        $product->category_id = $validated['category_id'];

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
