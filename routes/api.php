<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaketController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('profile', [LoginController::class, 'fetch']);
    Route::post('profile', [LoginController::class, 'updateProfile']);
    Route::post('logout', [LoginController::class, 'logout']);

    // Modul Paket
    Route::get('membership/paket', [PaketController::class, 'list']);
    Route::post('membership/paket', [PaketController::class, 'store']);
    Route::put('membership/paket/{paket}', [PaketController::class, 'update']);
    Route::delete('membership/paket/{paket}', [PaketController::class, 'destroy']);
});
