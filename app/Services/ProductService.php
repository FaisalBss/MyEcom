<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService
{

    public function getPaginated(int $perPage = 9)
{
    return Product::with('category')->paginate($perPage);
}

    public function create(array $data, Request $request): Product
    {
        $data['image'] = $this->handleImageUpload($request);
        return Product::create($data);
    }

    public function update(Product $product, array $data, Request $request): Product
    {
        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $data['image'] = $this->handleImageUpload($request);
        }

        $product->update($data);
        return $product;
    }

    public function delete(Product $product): void
    {
        $this->deleteImage($product->image);
        $product->delete();
    }

    private function handleImageUpload(Request $request): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        return $request->file('image')->store('products', 'public');
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function searchProducts(?string $search, int $perPage = 9)
    {
        $query = Product::with('category');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('id', $search)
                  ->orWhereHas('category', function ($cat) use ($search) {
                      $cat->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        return $query->paginate($perPage);
    }
}
