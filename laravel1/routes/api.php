<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CategoryController::class)->prefix('categories')->group(function(){
    Route::get('/', 'getCategories');
    Route::post("/", 'createCategory');
    Route::get("/{categoryId}", 'getCategory');
    Route::put("/{categoryId}", 'updateCategory');
    Route::delete("/{categoryId}", 'deleteCategory');
});

Route::controller(ProductController::class)->prefix('products')->group(function(){
    Route::get('/', 'getProducts');
    Route::post("/", 'createProduct');
    Route::get("/{productId}", 'getProduct');
    Route::patch("/{productId}", 'updateProduct');
    Route::delete("/{productId}", 'deleteProduct');
});
Route::controller(OrderController::class)->prefix('orders')->group(function(){
    Route::get('/', 'getOrders');
    Route::post("/", 'createOrder');
    Route::get("/{orderId}", 'getOrder');
    Route::put("/{orderId}", 'updateOrder');
    Route::delete("/{orderId}", 'deleteOrder');
});

Route::controller(CustomerController::class)->prefix('customers')->group(function(){
    Route::get('/', 'getCustomers');
    Route::post("/", 'createCustomer');
    Route::get("/{customerId}", 'getCustomer');
    Route::put("/{customerId}", 'updateCustomer');
    Route::delete("/{customerId}", 'deleteCustomer');
});
Route::fallback(function () {
    return response()->json(['message' => 'Route not found'], 404);
});
