<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupportRequestController;
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
use App\Http\Controllers\OrderController;

Route::get('/', [FirstController::class, 'MainPage'])->name('mainpage');

Route::get('/product/{catid?}', [FirstController::class, 'GetCategoryProduct'])->name('products.index');

Route::get('/category', [FirstController::class, 'GetAllCategoryWithProduct'])->name('products.byCategory');

Route::get('/404' , [FirstController::class, 'NotFoundPage'])->name('notfoundpage');

Route::post('/searchProducts', [FirstController::class, 'SearchProducts'])->name('products.search');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [FirstController::class, 'AdminDashboard'])->name('admin.dashboard');

    Route::get('/product',[AdminController::class, 'AdminProducts'])->name('admin.products');

    Route::get('/support',[SupportRequestController::class, 'adminIndex'])->name('admin.contact');
    Route::get('/support/{id}',[SupportRequestController::class, 'adminShow'])->name('admin.show');
    Route::patch('/support/{id}/status',[SupportRequestController::class, 'adminUpdateStatus'])->name('admin.status');
    Route::post('/{id}/comment', [SupportRequestController::class, 'adminAddComment'])->name('admin.comment');

    Route::get('/addproduct', [ProductController::class, 'AddProduct'])->name('products.add');
    Route::post('/storeProduct', [ProductController::class, 'StoreProduct'])->name('products.store');
    Route::get('/editProduct/{productid}', [ProductController::class, 'EditProduct'])->name('products.edit');
    Route::put('/updateProduct/{productid}', [ProductController::class, 'UpdateProduct'])->name('products.update');
    Route::delete('/deleteProduct/{productid}', [ProductController::class, 'DeleteProduct'])->name('products.destroy');

    Route::get('/user-orders', [AdminController::class, 'index'])->name('admin.orders.index');
    Route::post('/user-orders/{id}/update', [AdminController::class, 'updateStatus'])->name('admin.orders.update');
    Route::get('/orders/search', [AdminController::class, 'searchOrders'])->name('admin.orders.search');

});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/shipping', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
    Route::post('/shipping/store', [CheckoutController::class, 'storeShipping'])->name('checkout.shipping.store');
    Route::post('/shipping/select', [CheckoutController::class, 'selectShipping'])->name('checkout.shipping.select');


    // Payment
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/payment/save', [CheckoutController::class, 'savePaymentMethod'])->name('checkout.payment.save');
    Route::post('/payment/place', [CheckoutController::class, 'placeOrder'])->name('checkout.payment.place');

    // Orders
    Route::get('/myorders', [OrderController::class, 'UserOrders'])->name('user.Orders');


    Route::get('/contact',[SupportRequestController::class, 'index'])->name('contact.index');
    Route::get('/contact/previous',[SupportRequestController::class, 'previous'])->name('contact.previous');
    Route::get('/contact/new',[SupportRequestController::class, 'create'])->name('contact.new');
    Route::post('/contact/new',[SupportRequestController::class, 'store'])->name('contact.store');

});




require __DIR__.'/auth.php';
