<?php

use App\Http\Controllers\FirstController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Category;



Route::get('/', [FirstController::class, 'MainPage']);
Route::get('/product/{catid?}', [FirstController::class, 'GetCategoryProduct'] );
Route::get('/category', [FirstController::class, 'GetAllCategoryWithProduct']);
Route::get('/addproduct', [ProductController::class, 'AddProduct']);
Route::post('/storeProduct', [ProductController::class, 'StoreProduct']);
//  function ($catid = null) {

//{catid}', [FirstController::class, 'GetCategoryProduct']);


// });

//     $result = DB::table('products')->where('category_id' ,$catid)->get();
//     return view('product', ['products' => $result]);
// });


