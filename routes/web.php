<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::redirect('/', '/products');

Route::resource('products', ProductController::class);

// Quantity funkcionalitāte
Route::post('products/{product}/increase', [ProductController::class, 'increase'])->name('products.increase');
Route::post('products/{product}/decrease', [ProductController::class, 'decrease'])->name('products.decrease');
Route::post('/tags', [ProductController::class, 'addTag'])->name('tags.store');


