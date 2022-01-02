<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\IncomeController;

Route::prefix('/')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name("index");
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name("category.index");
        Route::get('/add', [CategoryController::class, 'categoryAddShow'])->name("category.add");
        Route::post('/add', [CategoryController::class, 'categoryAdd']);
        Route::post('/changeStatus', [CategoryController::class, 'changeStatus'])->name("category.changeStatus");
        Route::post('/delete', [CategoryController::class, 'delete'])->name("category.delete");
        Route::get('/update', [CategoryController::class, 'updateShow'])->name("category.updateShow");
        Route::put('/update', [CategoryController::class, 'update'])->name("category.update");
    });
    Route::prefix('income')->group(function () {
        Route::get('/', [IncomeController::class, 'index'])->name("income.index");
        Route::get('/add', [IncomeController::class, 'incomeAddShow'])->name("income.add");
        Route::post('/add', [IncomeController::class, 'incomeAdd']);
        Route::post('/changeStatus', [IncomeController::class, 'changeStatus'])->name("income.changeStatus");
        Route::post('/delete', [IncomeController::class, 'delete'])->name("income.delete");
        Route::get('/update/{id?}', [IncomeController::class, 'updateShow'])->name("income.updateShow");
        Route::put('/update', [IncomeController::class, 'update'])->name("income.update");
    });
    Route::prefix('expenditure')->group(function () {
        Route::get('/', [ExpenditureController::class, 'index'])->name("expenditure.index");
        Route::get('/add', [ExpenditureController::class, 'expenditureAddShow'])->name("expenditure.add");
        Route::post('/add', [ExpenditureController::class, 'expenditureAdd']);
        Route::post('/changeStatus', [ExpenditureController::class, 'changeStatus'])->name("expenditure.changeStatus");
        Route::post('/delete', [ExpenditureController::class, 'delete'])->name("expenditure.delete");
        Route::get('/update/{id?}', [ExpenditureController::class, 'updateShow'])->name("expenditure.updateShow");
        Route::put('/update', [ExpenditureController::class, 'update'])->name("expenditure.update");
    });
});
