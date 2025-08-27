<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirstController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;
use App\Models\Category;


Route::get('/', [FirstController::class, 'MainPage'])->name('mainpage');

Route::get('/product/{catid?}', [FirstController::class, 'GetCategoryProduct'])->name('categories.index');

Route::get('/category', [FirstController::class, 'GetAllCategoryWithProduct'])->name('products.byCategory');

Route::get('/addproduct', [ProductController::class, 'AddProduct'])->name('products.add');

Route::post('/storeProduct', [ProductController::class, 'StoreProduct'])->name('products.store');

Route::get('/editProduct/{productid}', [ProductController::class, 'EditProduct'])->name('products.edit');

Route::put('/updateProduct/{productid}', [ProductController::class, 'UpdateProduct'])->name('products.update');

Route::delete('/deleteProduct/{productid}', [ProductController::class, 'DeleteProduct'])->name('products.destroy');
Route::post('/searchProducts', [FirstController::class, 'SearchProducts'])->name('products.search');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
