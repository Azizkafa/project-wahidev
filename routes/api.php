<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;


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

});
