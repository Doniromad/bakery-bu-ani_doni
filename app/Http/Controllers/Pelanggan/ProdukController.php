<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Banner;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * 1. HALAMAN BERANDA (Landing Page)
     */
    public function home()
    {
        $banner = Banner::first();

        // UBAH DISINI: Ambil maksimal 6 produk TERBARU
        $produks = Produk::where('stok', '>', 0)
            ->latest()
            ->take(6) 
            ->get();

        // Tetap mengambil maksimal 3 produk TERFAVORIT
        $favorit_produks = Produk::where('stok', '>', 0)
            ->orderBy('terjual', 'desc') 
            ->take(3) 
            ->get();

        return view('index', compact('banner', 'produks', 'favorit_produks'));
    }

    /**
     * 2. HALAMAN KATALOG (Produk Index)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort   = $request->input('sort', 'terbaru'); 
        $kategoris = Kategori::all();

        $query = Produk::where('stok', '>', 0);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($sort == 'termurah') {
            $query->orderBy('harga', 'asc');
        } elseif ($sort == 'termahal') {
            $query->orderBy('harga', 'desc');
        } else {
            $query->latest(); 
        }

        $produks = $query->paginate(12)->withQueryString();

        return view('pelanggan.produk.index', compact('produks', 'kategoris', 'search'));
    }

    /**
     * 3. HALAMAN KATEGORI
     */
    public function category(Request $request, $slug)
    {
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        $kategoris = Kategori::all();
        $sort = $request->input('sort', 'terbaru');

        $query = Produk::where('kategori_id', $kategori->id)
                       ->where('stok', '>', 0);

        if ($sort == 'termurah') {
            $query->orderBy('harga', 'asc');
        } elseif ($sort == 'termahal') {
            $query->orderBy('harga', 'desc');
        } else {
            $query->latest();
        }

        $produks = $query->paginate(12)->withQueryString();

        return view('pelanggan.produk.index', compact('produks', 'kategori', 'kategoris'));
    }

    /**
     * 4. HALAMAN DETAIL PRODUK
     */
    public function show(Produk $produk)
    {
        return view('pelanggan.produk.show', compact('produk'));
    }
}