<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransactionController;
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

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);
Route::get('paket/list', [PaketController::class, 'listForMember']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('profile', [LoginController::class, 'fetch']);
    Route::post('profile/update', [LoginController::class, 'updateProfile']);
    Route::post('logout', [LoginController::class, 'logout']);

    // Modul Paket

    Route::get('membership/paket', [PaketController::class, 'list']);
    Route::get('membership/paket/{paket}', [PaketController::class, 'show']);
    Route::post('membership/paket', [PaketController::class, 'store']);
    Route::post('membership/paket/{paket}/update', [PaketController::class, 'update']);
    Route::delete('membership/paket/{paket}', [PaketController::class, 'destroy']);
    Route::post('membership/paket/{paket}/restore', [PaketController::class, 'restore']);

    // Modul Paket
    Route::get('membership/list', [MembershipController::class, 'list']);
    Route::get('membership/list/{membership}', [MembershipController::class, 'show']);
    Route::post('membership/list', [MembershipController::class, 'store']);
    Route::post('membership/list/{membership}/update', [MembershipController::class, 'update']);
    Route::delete('membership/list/{membership}', [MembershipController::class, 'destroy']);

    // Modul Transaction
    Route::get('membership/transaction', [TransactionController::class, 'list']);
    Route::get('membership/checkout/{transaction}', [TransactionController::class, 'listOne']);
    Route::post('membership/checkout', [TransactionController::class, 'store']);
    Route::post('membership/transaction/callback', [TransactionController::class, 'callback']);
    Route::get('membership/transaction/status', [TransactionController::class, 'checkStatus']);

    Route::post('membership/checkout/{transaction}/cancel', [TransactionController::class, 'cancleTransaction']);

    Route::post('membership/checkout/{transaction}/update', [TransactionController::class, 'update']);
    Route::delete('membership/checkout/{transaction}', [TransactionController::class, 'destroy']);
});
