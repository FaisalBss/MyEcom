<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Products CRUD
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);
Route::post('/products', [ProductApiController::class, 'store']);
Route::put('/products/{id}', [ProductApiController::class, 'update']);
Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);

// Categories
Route::get('/categories', [ProductApiController::class, 'categories']);
Route::get('/categories/{catid}/products', [ProductApiController::class, 'getByCategory']);

// Search
Route::get('/products/search', [ProductApiController::class, 'search']);
