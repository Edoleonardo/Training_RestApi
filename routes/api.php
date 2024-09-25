<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return response()->json(['data' => "hello word"]);
});


Route::get('/testapi', [ProductsController::class, 'index']);
Route::get('/products', [ProductsController::class, 'getproducts']);
Route::get('/products/{id}/asd', [ProductsController::class, 'getproduct']);
Route::post('/products', [ProductsController::class, 'store']);
Route::put('/products/{id}/asd', [ProductsController::class, 'update']);
Route::delete('/products/{id}/asd', [ProductsController::class, 'delete']);
