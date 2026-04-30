<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator; // Tambahkan ini untuk paginasi Bootstrap
use App\Models\Kategori;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Bagikan data kategori ke view pelanggan agar navbar kategori selalu update
        // Saya sarankan batasi ke view tertentu (misal layout pelanggan) agar tidak membebani Admin
        View::composer(['layouts.pelanggan', 'index', 'pelanggan.*'], function ($view) {
            $view->with('global_kategoris', Kategori::all());
        });

        // 2. Setting Paginasi agar menggunakan style Bootstrap
        // Berguna agar tampilan 'Next/Previous' di produk tidak berantakan
        Paginator::useBootstrapFive();
    }
}