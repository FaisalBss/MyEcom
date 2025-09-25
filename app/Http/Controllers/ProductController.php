<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function AddProduct()
    {
        $allCategories = Category::all();
        return view('Products.addproduct', ['categories' => $allCategories]);
    }

    public function StoreProduct(StoreProductRequest $request)
    {
        $this->productService->create($request->validated(), $request);

        return redirect()->route('admin.dashboard')
            ->with('status', 'Product created successfully!');
    }

    public function EditProduct($productid)
    {
        $product = Product::findOrFail($productid);
        $categories = Category::all();

        return view('Products.editproduct', compact('product', 'categories'));
    }

    public function UpdateProduct(UpdateProductRequest $request, $productid)
    {
        $product = Product::findOrFail($productid);
        $this->productService->update($product, $request->validated(), $request);

        return redirect()->route('admin.dashboard')
            ->with('status', 'Product updated successfully!');
    }

    public function DeleteProduct($productid = null)
    {
        if ($productid) {
            $product = Product::find($productid);
            if ($product) {
                $this->productService->delete($product);
            }
        }

        return redirect()->back();
    }
}
