<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

Route::get('/', [LoginController::class, 'chooseRole'])->name('login.chooseRole');

Route::get('/login/pembeli', [LoginController::class, 'showPembeliLogin'])->name('login.pembeli');
Route::get('/login/penjual', [LoginController::class, 'showPenjualLogin'])->name('login.penjual');

// Registrasi pembeli
Route::get('/register/pembeli', [LoginController::class, 'showPembeliRegister'])->name('register.pembeli');
Route::post('/register/pembeli', [LoginController::class, 'registerPembeli'])->name('register.pembeli.store');

Route::post('/login', [LoginController::class, 'login'])->name('login.process');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/penjual/dashboard', [OrderController::class, 'penjualDashboard'])->name('penjual.dashboard');
Route::get('/penjual/pesanan', [OrderController::class, 'penjualPesanan'])->name('penjual.pesanan');
Route::get('/penjual/terjadwal', [OrderController::class, 'penjualTerjadwal'])->name('penjual.terjadwal');
Route::get('/penjual/pesanan/{order}', [OrderController::class, 'penjualDetailPesanan'])->name('penjual.pesanan.detail');
Route::post('/penjual/pesanan/update-status', [OrderController::class, 'updateStatus'])->name('penjual.pesanan.updateStatus');
Route::get('/pembeli/dashboard', [MenuController::class, 'pembeliDashboard'])->name('pembeli.dashboard');
Route::view('/pembeli/profile', 'dashboards.pembeli-profile')->name('pembeli.profile');
Route::get('/pembeli/pesanan-saya', [OrderController::class, 'pembeliPesanan'])->name('pembeli.pesanan');
Route::get('/pembeli/menu', [MenuController::class, 'pembeliMenu'])->name('pembeli.menu');
Route::view('/pembeli/pembayaran', 'dashboards.pembeli-pembayaran')->name('pembeli.pembayaran');
Route::post('/pembeli/pembayaran/store', [OrderController::class, 'store'])->name('pembeli.pembayaran.store');
Route::post('/pembeli/pembayaran/update-status', [OrderController::class, 'updateStatus'])->name('pembeli.pembayaran.updateStatus');
