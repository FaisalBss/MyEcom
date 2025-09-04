<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirstController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CarttControl;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\PaymentMethodController;

Route::get('/', [FirstController::class, 'MainPage'])->name('mainpage');

Route::get('/product/{catid?}', [FirstController::class, 'GetCategoryProduct'])->name('products.index');

Route::get('/category', [FirstController::class, 'GetAllCategoryWithProduct'])->name('products.byCategory');
Route::get('/404' , [FirstController::class, 'NotFoundPage'])->name('notfoundpage');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/addproduct', [ProductController::class, 'AddProduct'])->name('products.add');
    Route::post('/storeProduct', [ProductController::class, 'StoreProduct'])->name('products.store');
    Route::get('/editProduct/{productid}', [ProductController::class, 'EditProduct'])->name('products.edit');
    Route::put('/updateProduct/{productid}', [ProductController::class, 'UpdateProduct'])->name('products.update');
    Route::delete('/deleteProduct/{productid}', [ProductController::class, 'DeleteProduct'])->name('products.destroy');
});

Route::post('/searchProducts', [FirstController::class, 'SearchProducts'])->name('products.search');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::match(['POST','GET'], '/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/place', [CartController::class, 'placeOrder'])->name('checkout.place');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/shipping-address/upsert', [ShippingAddressController::class, 'upsert'])->name('shipping.upsert');

    Route::post('/payment-methods/upsert', [PaymentMethodController::class, 'upsert'])->name('payment-methods.upsert');
});

require __DIR__.'/auth.php';
