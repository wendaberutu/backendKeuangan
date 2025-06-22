<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TransactionController;


// Route::get('/user', function (Request $request) {
// return $request->user();
// })->middleware('auth:sanctum');

// Route::apiResource('product', ProductController::class);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');


Route::prefix('user')->middleware(['auth:api', 'isOwner'])->group(function () {
    // Menampilkan daftar admin
    Route::get('', [UserController::class, 'index']);

    // Menambahkan admin baru
    Route::post('', [UserController::class, 'store']);

    // Melihat detail admin
    Route::get('/{id}', [UserController::class, 'show']);

    // Mengupdate data admin
    Route::put('/{id}', [UserController::class, 'update']);

    // Menghapus admin
    Route::delete('/{id}', [UserController::class, 'destroy']);
});



 Route::middleware(['auth:api', 'isAdmin'])->get('/transactions', [TransactionController::class, 'index']);
// Route::get('/transactions', [TransactionController::class, 'index']);

//  Route::middleware(['auth:api', 'isAdmin'])->get('/transactions', [TransactionController::class, 'index']);
// Route::middleware(['auth:api', 'isOwner'])->get('/user', [UserController::class, 'index']);
// Route::middleware(['auth:api', 'isOwner'])->post('/user', [UserController::class, 'index']);






// Route::middleware('auth:api')->get('/user', function (Request $request) {
// return response()->json($request->user());
// });



// Route::get('/transactions', [TransactionController::class, 'index']);


Route::get('/accounts', [AccountController::class, 'index']);
Route::post('/accounts', [AccountController::class, 'store']);
Route::get('/accounts/{account}', [AccountController::class, 'show']);
Route::put('/accounts/{account}', [AccountController::class, 'update']);
Route::delete('/accounts/{account}', [AccountController::class, 'destroy']);



// Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::put('/transactions/{transaction}', [TransactionController::class, 'update']);
Route::patch('/transactions/{transaction}', [TransactionController::class, 'update']);
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy']);


Route::get('/laporan/jurnal-umum', [ReportController::class, 'getJurnalUmumByMonth']);
Route::get('/laporan/buku-besar', [ReportController::class, 'getBukuBesarByRekening']);