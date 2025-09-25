<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductService
{
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

        $uploadsPath = public_path('uploads');
        if (!File::exists($uploadsPath)) {
            File::makeDirectory($uploadsPath, 0755, true);
        }

        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move($uploadsPath, $imageName);

        return 'uploads/' . $imageName;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
}
