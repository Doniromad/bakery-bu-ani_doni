<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Banner;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data banner (Hero Image)
        $banner = Banner::first();

        // 2. Ambil kata kunci dari input 'search'
        $search = $request->input('search');

        // 3. Ambil semua kategori untuk filter
        $kategoris = Kategori::all();

        // 4. Query produk yang stoknya tersedia
        $produks = Produk::where('stok', '>', 0)
            ->when($search, function($query, $search) {
                return $query->where('nama_produk', 'like', "%{$search}%")
                             ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // 5. Logika Penentu: Apakah user sedang di Beranda atau di Katalog Produk?
        // Flag $is_home akan bernilai true jika user mengakses URL '/'
        $is_home = $request->is('/');

        return view('pelanggan.produk.index', compact('produks', 'kategoris', 'search', 'banner', 'is_home'));
    }

    /**
     * Menampilkan produk berdasarkan kategori
     */
    public function category($slug)
    {
        // Tetap ambil banner (opsional, bisa disembunyikan di blade lewat $is_home)
        $banner = Banner::first();
        
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        $kategoris = Kategori::all();

        $produks = Produk::where('kategori_id', $kategori->id)
                         ->where('stok', '>', 0)
                         ->latest()
                         ->paginate(12)
                         ->withQueryString();

        // Jika masuk kategori, maka bukan lagi di halaman Beranda utama
        $is_home = false;

        return view('pelanggan.produk.index', compact('produks', 'kategori', 'kategoris', 'banner', 'is_home'));
    }

    public function show(Produk $produk)
    {
        return view('pelanggan.produk.show', compact('produk'));
    }
}