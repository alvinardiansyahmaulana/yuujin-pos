<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\VariantController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Sales\SalesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth API
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);

//Category API
Route::apiResource('/category', CategoryController::class)->middleware('auth:api');

//Product and Product Variant API
Route::apiResource('/product', ProductController::class)->middleware('auth:api');
Route::apiResource('/product.variant', VariantController::class)->middleware('auth:api');

//Invoice API
Route::apiResource('/invoice', InvoiceController::class)->middleware('auth:api');

//Sales API
Route::apiResource('/sales', SalesController::class)->middleware('auth:api');
