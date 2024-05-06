<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\TransactionTypeController;
use App\Http\Controllers\Admin\TipController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PamController;
use App\Http\Controllers\Admin\RedirectPaymentController;
use App\Http\Controllers\Admin\TagihanController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', [AuthController::class, 'index'])->name('admin.auth.index');
    Route::post('login', [AuthController::class, 'login'])->name('admin.auth.login');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.auth.logout');

    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('admin.dashboard');

        Route::get('/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
            Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
            Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
            Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        });

        Route::group(['prefix' => 'pams'], function () {
            Route::get('/', [PamController::class, 'index'])->name('admin.pams.index');
            Route::get('/create', [PamController::class, 'create'])->name('admin.pams.create');
            Route::post('/store', [PamController::class, 'store'])->name('admin.pams.store');
            Route::get('/edit/{id}', [PamController::class, 'edit'])->name('admin.pams.edit');
            Route::put('/update/{id}', [PamController::class, 'update'])->name('admin.pams.update');
            Route::delete('/destroy/{id}', [PamController::class, 'destroy'])->name('admin.pams.destroy');
        });

        Route::group(['prefix' => 'tagihan'], function () {
            Route::get('/', [TagihanController::class, 'index'])->name('admin.tagihan.index');
            Route::get('/create', [TagihanController::class, 'create'])->name('admin.tagihan.create');
            Route::post('/store', [TagihanController::class, 'store'])->name('admin.tagihan.store');
            Route::get('/edit/{id}', [TagihanController::class, 'edit'])->name('admin.tagihan.edit');
            Route::put('/update/{id}', [TagihanController::class, 'update'])->name('admin.tagihan.update');
            Route::delete('/destroy/{id}', [TagihanController::class, 'destroy'])->name('admin.tagihan.destroy');
        });


        Route::group(['prefix' => 'payment_methods'], function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('admin.payment_methods.index');
            Route::get('/create', [PaymentMethodController::class, 'create'])->name('admin.payment_methods.create');
            Route::post('/store', [PaymentMethodController::class, 'store'])->name('admin.payment_methods.store');
            Route::get('/edit/{id}', [PaymentMethodController::class, 'edit'])->name('admin.payment_methods.edit');
            Route::put('/update/{id}', [PaymentMethodController::class, 'update'])->name('admin.payment_methods.update');
            Route::delete('/destroy/{id}', [PaymentMethodController::class, 'destroy'])->name('admin.payment_methods.destroy');
        });

        Route::group(['prefix' => 'transaction_types'], function () {
            Route::get('/', [TransactionTypeController::class, 'index'])->name('admin.transaction_types.index');
            Route::get('/create', [TransactionTypeController::class, 'create'])->name('admin.transaction_types.create');
            Route::post('/store', [TransactionTypeController::class, 'store'])->name('admin.transaction_types.store');
            Route::get('/edit/{id}', [TransactionTypeController::class, 'edit'])->name('admin.transaction_types.edit');
            Route::put('/update/{id}', [TransactionTypeController::class, 'update'])->name('admin.transaction_types.update');
            Route::delete('/destroy/{id}', [TransactionTypeController::class, 'destroy'])->name('admin.transaction_types.destroy');
        });

        Route::group(['prefix' => 'tips'], function () {
            Route::get('/', [TipController::class, 'index'])->name('admin.tips.index');
            Route::get('/create', [TipController::class, 'create'])->name('admin.tips.create');
            Route::post('/store', [TipController::class, 'store'])->name('admin.tips.store');
            Route::get('/edit/{id}', [TipController::class, 'edit'])->name('admin.tips.edit');
            Route::put('/update/{id}', [TipController::class, 'update'])->name('admin.tips.update');
            Route::delete('/destroy/{id}', [TipController::class, 'destroy'])->name('admin.tips.destroy');
        });
    });
});

Route::get('/payment_finish', [RedirectPaymentController::class, 'finish']);
