<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.index');
        Route::post('/', [AccountController::class, 'store'])->name('account.store');
        Route::post('{accountCode}/add-initial-balance', [AccountController::class, 'addInitialBalance']);
        Route::post('import', [AccountController::class, 'import'])->name('account.import');
        Route::get('input-balance', [AccountController::class, 'inputBalance'])->name('account.inputBalance');
        Route::post('initial-balance', [AccountController::class, 'storeInitialBalance'])->name('account.store.initialBalance');

    });

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('add', [CategoryController::class, 'add'])->name('category.add');
        Route::post('store', [CategoryController::class, 'store'])->name('category.store');
        Route::post('import', [CategoryController::class, 'import'])->name('category.import');
    });

    Route::prefix('transaction')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transaction.index');
        Route::post('store', [TransactionController::class, 'store'])->name('transaction.store');
    });

    Route::prefix('accounting')->group(function () {
        Route::get('balance-sheet', [AccountingController::class, 'balanceSheet'])->name('accounting.balanceSheet');
        Route::get('profit-loss', [AccountingController::class, 'profitLoss'])->name('accounting.profitLoss');
    });
});

require __DIR__ . '/auth.php';
