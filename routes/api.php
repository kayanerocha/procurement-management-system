<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Support\Facades\Route;

Route::resource('suppliers', SupplierController::class)->only([
    'index', 'show', 'store', 'update'
]);

Route::resource('products', ProductController::class)->only([
    'index', 'show', 'store', 'update'
]);