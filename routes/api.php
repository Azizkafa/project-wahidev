<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\TransactionDetailController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ReportController;

// register
Route::post('/register', [AuthController::class, 'register']);

// login
Route::post('/login', [AuthController::class, 'login']);



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//tampil semua data
Route::get('/products', [ProductController::class, 'index']);

//tampil 1 data
Route::get('/products/{id}', [ProductController::class, 'show']);

// simpan data
Route::post('/products', [ProductController::class, 'store']);

// hapus data
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// update data
Route::post('/products/{id}', [ProductController::class, 'update']);


// api order
Route::middleware('auth:sanctum')->group(function() {

    //khusus untuk semua api yang mengharuskan login
    Route::post('/order', [OrderController::class, 'order']);

    //khusus untuk admin
    Route::post('/konfirmasi-order', [OrderController::class, 'konfirmasi']);


    // Transaction Routes
    Route::get('transactions', [TransactionController::class, 'index']);
    Route::get('transactions/{id}', [TransactionController::class, 'show']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::put('transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);

    // Menu Routes
    Route::get('menus', [MenuController::class, 'index']);
    Route::get('menus/{id}', [MenuController::class, 'show']);
    Route::post('menus', [MenuController::class, 'store']);
    Route::put('menus/{id}', [MenuController::class, 'update']);
    Route::delete('menus/{id}', [MenuController::class, 'destroy']);



// Route untuk Transaction Detail
Route::get('transaction-details', [TransactionDetailController::class, 'index']);
Route::get('transaction-details/{id}', [TransactionDetailController::class, 'show']);
Route::post('transaction-details', [TransactionDetailController::class, 'store']);
Route::put('transaction-details/{id}', [TransactionDetailController::class, 'update']);
Route::delete('transaction-details/{id}', [TransactionDetailController::class, 'destroy']);

    // --- Route Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // --- Route Sales / Laporan Penjualan ---
    Route::get('/report', [ReportController::class, 'index']);
    Route::get('/report/{id}', [ReportController::class, 'show']);

});




