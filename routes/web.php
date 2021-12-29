<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;

Route::prefix('/')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name("index");
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name("category.index");
        Route::get('/add', [CategoryController::class, 'categoryAddShow'])->name("category.category-add");
        Route::post('/add', [CategoryController::class, 'categoryAdd']);
        Route::post('/changeStatus', [CategoryController::class, 'changeStatus'])->name("category.changeStatus");
        Route::post('/delete', [CategoryController::class, 'delete'])->name("category.delete");
        Route::get('/update', [CategoryController::class, 'updateShow'])->name("category.updateShow");
        Route::put('/update', [CategoryController::class, 'update'])->name("category.update");
    });
});
