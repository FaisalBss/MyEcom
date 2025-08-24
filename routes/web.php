<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $result = Category::all();
    return view('welcome', ['categories' => $result]);


});

Route::get('/category', function () {
    return view('category');
});

Route::get('/product/{catid?}', function ($catid = null) {


    if ($catid == null) {
        $result = DB::table('products')->get();
        return view('product', ['products' => $result]);
    }
    $result = DB::table('products')->where('category_id',$catid)->get();


    return view('product', ['products' => $result]);
});

