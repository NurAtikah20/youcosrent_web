<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiTransactionAndOtherList;
use App\Http\Controllers\Api\EditProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('validate')->group(function () {

    Route::post('/login', [ApiAuthController::class, 'loginUser']);
    Route::post('/register', [ApiAuthController::class, 'registerUser']);
    Route::get('/verified/{id}', [ApiAuthController::class, 'verified'])->name('verifiedEmail');
    Route::post('/editProfile', [EditProfile::class, 'editProfile']);
});

Route::post('transaction', [ApiTransactionAndOtherList::class, 'Transaction']);

Route::prefix('list')->group(function () {
    Route::get('/barang', [ApiTransactionAndOtherList::class, 'barang']);
    Route::get('/barangTerbaru', [ApiTransactionAndOtherList::class, 'barangBaru']);
    Route::get('/barangKategoriA', [ApiTransactionAndOtherList::class, 'barangKategoriA']);
    Route::get('/barangKategoriB', [ApiTransactionAndOtherList::class, 'barangKategoriB']);
    Route::get('/barangKategoriC', [ApiTransactionAndOtherList::class, 'barangKategoriC']);
    Route::get('/barangKategoriD', [ApiTransactionAndOtherList::class, 'barangKategoriD']);
    Route::get('/barangKategoriE', [ApiTransactionAndOtherList::class, 'barangKategoriE']);
    Route::get('/dataPesanan', [ApiTransactionAndOtherList::class, 'dataPesanan']);
    Route::get('/dataHistory', [ApiTransactionAndOtherList::class, 'dataHistory']);
});
