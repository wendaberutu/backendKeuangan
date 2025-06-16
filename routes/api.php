<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TransactionController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::apiResource('product', ProductController::class);

Route::get('/transactions', [TransactionController::class, 'index']);


Route::get('/accounts', [AccountController::class, 'index']);
Route::post('/accounts', [AccountController::class, 'store']);
Route::get('/accounts/{account}', [AccountController::class, 'show']);
Route::put('/accounts/{account}', [AccountController::class, 'update']);
Route::delete('/accounts/{account}', [AccountController::class, 'destroy']);



Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::put('/transactions/{transaction}', [TransactionController::class, 'update']);
Route::patch('/transactions/{transaction}', [TransactionController::class, 'update']);
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy']);


Route::get('/laporan/jurnal-umum', [ReportController::class, 'getJurnalUmumByMonth']);
Route::get('/laporan/buku-besar', [ReportController::class, 'getBukuBesarByRekening']);

