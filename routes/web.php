<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MerchantProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index']);
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/merchant_profile', [MerchantProfileController::class, 'index'])->name('merchant.profile');
    Route::get('/merchant_profile/edit', [MerchantProfileController::class, 'edit'])->name('merchant.profile.edit');
    Route::post('/merchant_profile/update', [MerchantProfileController::class, 'update'])->name('merchant.profile.update');

    Route::resource('menu', MenuController::class);

    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.index');

    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status');

    Route::get('/merchants', [MerchantController::class, 'index'])->name('merchants.index');
    Route::get('/merchants/{id}', [MerchantController::class, 'show'])->name('merchants.show');
});
