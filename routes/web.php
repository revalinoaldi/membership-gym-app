<?php

use App\Http\Controllers\DayinController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('membership/logout', [UsersController::class, 'setLogout'])->name('logout.member');

    Route::get('/home', function () {
        return view('templates.pages.dashboard');
    })->name('home');

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});

Route::get('test-url',function(){
    return url('api/login');
});


Route::resource('paket', PaketController::class)->except(['store', 'show', 'update', 'destroy']);
Route::resource('transaksi', TransactionController::class)->except(['store', 'update', 'destroy']);
Route::resource('dayin', DayinController::class);
Route::resource('user/list', UsersController::class);
Route::resource('user/member', MemberController::class);
Route::get('transaksi/payment/{transaction}', [TransactionController::class, 'payment'])->name('transaksi.payment.member');


Route::post('membership/login', [UsersController::class, 'setLogin'])->name('login.member');
Route::post('membership/register', [UsersController::class, 'setRegister'])->name('register.member');
