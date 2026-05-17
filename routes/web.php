<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Pelanggan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;

// 1. HALAMAN UTAMA (Landing Page) - Bisa diakses siapa saja, tidak ada redirect ke admin
Route::get('/', [Pelanggan\ProdukController::class, 'home'])->name('home');

// ===== ADMIN ROUTES =====
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    
    // Kelola Produk
    Route::resource('produk', Admin\ProdukController::class);

    // Kelola Kategori (Fitur Baru)
    Route::resource('kategori', Admin\KategoriController::class);
    
    // Kelola Pesanan
    Route::get('pesanan', [Admin\PesananController::class, 'index'])->name('pesanan.index');
    Route::get('pesanan/{pesanan}', [Admin\PesananController::class, 'show'])->name('pesanan.show');
    Route::post('pesanan/{pesanan}/status', [Admin\PesananController::class, 'updateStatus'])->name('pesanan.status');
    
    // Laporan
    Route::get('laporan', [Admin\LaporanController::class, 'index'])->name('laporan');
    
    // SETTING BANK
    Route::resource('bank', Admin\BankController::class);
    
    // PENGATURAN BANNER
    Route::get('banner', [Admin\BannerController::class, 'index'])->name('banner.index');
    Route::post('banner', [Admin\BannerController::class, 'store'])->name('banner.store');
});

// ===== PELANGGAN ROUTES =====
Route::get('/produk', [Pelanggan\ProdukController::class, 'index'])->name('pelanggan.produk.index');
Route::get('/produk/{produk}', [Pelanggan\ProdukController::class, 'show'])->name('pelanggan.produk.show');
Route::get('/kategori/{slug}', [Pelanggan\ProdukController::class, 'category'])->name('pelanggan.kategori');

// Keranjang, checkout, riwayat harus login
Route::middleware(['auth'])->name('pelanggan.')->group(function () {
    Route::get('/keranjang', [Pelanggan\KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang', [Pelanggan\KeranjangController::class, 'store'])->name('keranjang.store');
    Route::delete('/keranjang/{keranjang}', [Pelanggan\KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    
    Route::get('/checkout', [Pelanggan\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [Pelanggan\CheckoutController::class, 'store'])->name('checkout.store');
    
    Route::get('/riwayat', [Pelanggan\PesananController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/{pesanan}', [Pelanggan\PesananController::class, 'show'])->name('riwayat.show');
    
    Route::post('/riwayat/{pesanan}/upload-bukti', [Pelanggan\PesananController::class, 'uploadBukti'])->name('pesanan.upload-bukti');
});

// Profil (Bisa diakses Admin & Pelanggan)
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

// Redirect setelah login berdasarkan role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('pelanggan.produk.index');
})->middleware('auth')->name('dashboard');

// ===== GOOGLE OAUTH ROUTES (SUDAH DIPERBAIKI) =====
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

require __DIR__.'/auth.php';