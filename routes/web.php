<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\IncomeController;

Route::prefix('/')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name("index");
    Route::get('/profile', [HomeController::class, 'profile'])->name("profile");
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name("category.index");
        Route::get('/add', [CategoryController::class, 'categoryAddShow'])->middleware('role:1,2')->name("category.add");
        Route::post('/add', [CategoryController::class, 'categoryAdd'])->middleware('role:1,2');
        Route::post('/changeStatus', [CategoryController::class, 'changeStatus'])->middleware('role:1,2')->name("category.changeStatus");
        Route::post('/delete', [CategoryController::class, 'delete'])->middleware('role:1,2')->name("category.delete");
        Route::get('/update', [CategoryController::class, 'updateShow'])->middleware('role:1,2')->name("category.updateShow");
        Route::put('/update', [CategoryController::class, 'update'])->middleware('role:1,2')->name("category.update");
    });
    Route::prefix('income')->group(function () {
        Route::get('/', [IncomeController::class, 'index'])->name("income.index");
        Route::post('/', [IncomeController::class, 'search']);
        Route::get('/add', [IncomeController::class, 'incomeAddShow'])->middleware('role:1,2')->name("income.add");
        Route::post('/add', [IncomeController::class, 'incomeAdd'])->middleware('role:1,2');
        Route::post('/delete', [IncomeController::class, 'delete'])->middleware('role:1,2')->name("income.delete");
        Route::get('/update/{id?}', [IncomeController::class, 'updateShow'])->middleware('role:1,2')->name("income.updateShow");
        Route::put('/update', [IncomeController::class, 'update'])->middleware('role:1,2')->name("income.update");
    });
    Route::prefix('expenditure')->group(function () {
        Route::get('/', [ExpenditureController::class, 'index'])->name("expenditure.index");
        Route::post('/', [ExpenditureController::class, 'search']);
        Route::get('/add', [ExpenditureController::class, 'expenditureAddShow'])->middleware('role:1,2')->name("expenditure.add");
        Route::post('/add', [ExpenditureController::class, 'expenditureAdd'])->middleware('role:1,2');
        Route::post('/delete', [ExpenditureController::class, 'delete'])->middleware('role:1,2')->name("expenditure.delete");
        Route::get('/update/{id?}', [ExpenditureController::class, 'updateShow'])->middleware('role:1,2')->name("expenditure.updateShow");
        Route::put('/update', [ExpenditureController::class, 'update'])->middleware('role:1,2')->name("expenditure.update");
    });
});
