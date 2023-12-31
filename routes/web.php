<?php

use App\Http\Controllers\DayinController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use App\Models\TransactionMembership;
use App\Notifications\SuccessPaymentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
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
    'web',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::post('member/logout', [UsersController::class, 'setLogout'])->name('logout.member');

    Route::get('/home', function () {
        return view('templates.pages.dashboard');
    })->name('home');

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::resource('paket', PaketController::class)->except(['store', 'show', 'update', 'destroy']);
    Route::post('paket/save', [PaketController::class, 'submitCreate'])->name('save.paket');
    Route::post('paket/update/{paket}', [PaketController::class, 'submitUpdate'])->name('update.paket');
    Route::delete('paket/delete/{paket}', [PaketController::class, 'submitDelete'])->name('delete.paket');
    Route::post('paket/restore/{paket}', [PaketController::class, 'submitRestore'])->name('restore.paket');

    Route::resource('transaksi', TransactionController::class)->except(['store', 'update', 'destroy']);
    Route::get('transaksi/print/{transaction}', [TransactionController::class, 'print'])->name('transaksi.invoice.print');
    Route::get('transaksi/payment/{transaction}', [TransactionController::class, 'payment'])->name('transaksi.payment.member');
    Route::post('transaksi/checkout', [TransactionController::class, 'checkout'])->name('transaksi.payment.checkout');
    Route::get('transaksi-success', [TransactionController::class, 'setCallback'])->name('transaksi.payment.setcallback');

    Route::resource('dayin', DayinController::class);
    Route::get('dayin-all', [DayinController::class, 'all'])->name('dayin.list.all');

    Route::resource('user/list', UsersController::class);
    Route::resource('user/member', MemberController::class);
    Route::get('profile', [UsersController::class, 'profile'])->name('user.profile');
    Route::post('profile/update', [UsersController::class, 'profileUpdate'])->name('user.profile.update');

    Route::get('/test-email', function(){
        $user = Auth::user();
        $transaction = TransactionMembership::where('kode_transaksi', '0310-2023-225420-248-278-99')->first();
        // dd($user->toArray());
        try {
            Notification::send($user, new SuccessPaymentNotification($transaction));
            var_dump('success');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    });

    Route::resource('kunjungan', KunjunganController::class);

});

Route::get('test-url',function(){
    return url('api/login');
});




Route::post('membership/login', [UsersController::class, 'setLogin'])->name('login.member');
Route::post('membership/register', [UsersController::class, 'setRegister'])->name('register.member');
