<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Support\Facades\Route;

Route::resource('suppliers', SupplierController::class)->only([
    'index', 'show', 'store', 'update'
]);

Route::resource('products', ProductController::class)->only([
    'index', 'show', 'store', 'update'
]);

Route::resource('orders', OrderController::class)->only([
    'index', 'show', 'store', 'update'
]);

Route::get('/suppliers/active-suppliers', [SupplierController::class, 'activeSuppliers'])->name('suppliers.active-suppliers');

Route::get('/products/{product}/linked-suppliers', [ProductController::class, 'linkedSuppliers'])->name('products.linked-suppliers');
Route::get('/products/{product}/unrelated-suppliers', [ProductController::class, 'unrelatedSuppliers'])->name('products.unrelated-suppliers');
Route::post('/products/{product}/link-suppliers', [ProductController::class, 'linkSuppliers'])->name('products.link-suppliers');
Route::post('/products/{product}/unlink-suppliers', [ProductController::class, 'unlinkSuppliers'])->name('products.unlink-suppliers');