<?php

use App\Http\Controllers\AdminController\CategoryController;
use App\Http\Controllers\AdminController\ProductController;
use App\Http\Controllers\AdminController\ProductImageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('product_images', ProductImageController::class);

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
