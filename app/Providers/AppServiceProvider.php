<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Tambahkan ini
use App\Models\Kategori; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Bagikan data kategori ke semua view yang menggunakan layout pelanggan
        View::composer('*', function ($view) {
            $view->with('global_kategoris', Kategori::all());
        });
    }
}