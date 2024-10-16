<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Home;
use App\Livewire\Laporan;
use App\Livewire\Member;
use App\Livewire\Petugas;
use App\Livewire\Produk;
use App\Livewire\Transaksi;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', Home::class)->middleware(['auth'])->name('home');
Route::get('/laporan', Laporan::class)->middleware(['auth'])->name('laporan');
Route::get('/member', Member::class)->middleware(['auth'])->name('member');
Route::get('/petugas', Petugas::class)->middleware(['auth'])->name('petugas');
Route::get('/produk', Produk::class)->middleware(['auth'])->name('produk');
Route::get('/transaksi', Transaksi::class)->middleware(['auth'])->name('transaksi');
Route::get('/cetaktransaksi', ['App\Http\Controllers\HomeController', 'cetakTransaksi']);
Route::get('/cetakpetugas', ['App\Http\Controllers\HomeController', 'cetakPetugas']);
Route::get('/cetakproduk', ['App\Http\Controllers\HomeController', 'cetakProduk']);
Route::get('/cetakmember', ['App\Http\Controllers\HomeController', 'cetakMember']);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
