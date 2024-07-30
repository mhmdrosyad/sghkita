<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ResCategoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\InvoiceItemController;
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

    // Add the Customer routes
    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::post('store', [CustomerController::class, 'store'])->name('customer.store');
        Route::put('update/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('delete/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    });

    // Sales routes
    Route::prefix('sales')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('sales.index');
        Route::post('store', [SalesController::class, 'store'])->name('sales.store');
        Route::put('update/{sale}', [SalesController::class, 'update'])->name('sales.update');
        Route::delete('delete/{sale}', [SalesController::class, 'destroy'])->name('sales.destroy');
    });

    // Reservation Category routes
    Route::prefix('res_category')->group(function () {
        Route::get('/', [ResCategoryController::class, 'index'])->name('res_category.index');
        Route::post('store', [ResCategoryController::class, 'store'])->name('res_category.store');
        Route::put('update/{resCategory}', [ResCategoryController::class, 'update'])->name('res_category.update');
        Route::delete('delete/{resCategory}', [ResCategoryController::class, 'destroy'])->name('res_category.destroy');
    });

    // Reservation routes
    Route::prefix('reservations')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::post('store', [ReservationController::class, 'store'])->name('reservations.store');
        Route::put('update/{order_code}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('delete/{order_code}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });

    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('show/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::post('store', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::put('update/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('delete/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::post('items/add/{id}', [InvoiceController::class, 'addItem'])->name('invoice_items.add');
        Route::put('invoices/{invoice}/items/{item}', [InvoiceController::class, 'editItem'])->name('invoice_items.update');
        Route::delete('invoices/{invoice}/items/{item}', [InvoiceController::class, 'deleteItem'])->name('invoice_items.destroy');
    });

    Route::post('/payments/store', [PaymentsController::class, 'store'])->name('payments.store');

    // Delete a payment
    Route::delete('/payments/delete/{id}', [PaymentsController::class, 'destroy'])->name('payments.destroy');
});

require __DIR__ . '/auth.php';