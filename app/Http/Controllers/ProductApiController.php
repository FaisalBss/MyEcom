<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index()
    {
        $products = Product::paginate(10);
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated(), $request);

        return response()->json([
            'message' => 'Product created successfully!',
            'product' => $product
        ], 201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $updated = $this->productService->update($product, $request->validated(), $request);

        return response()->json([
            'message' => 'Product updated successfully!',
            'product' => $updated
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->productService->delete($product);

        return response()->json([
            'message' => 'Product deleted successfully!'
        ]);
    }

    public function categories()
    {
        return response()->json(Category::all());
    }

    public function getByCategory($catid = null)
    {
        $products = $catid
            ? Product::where('category_id', $catid)->paginate(9)
            : Product::paginate(9);

        return response()->json($products);
    }

    public function search(Request $request)
    {
        $searchKey = $request->input('searchKey');

        $products = Product::where('name', 'LIKE', "%$searchKey%")
            ->orWhere('description', 'LIKE', "%$searchKey%")
            ->paginate(9);

        return response()->json($products);
    }
}
