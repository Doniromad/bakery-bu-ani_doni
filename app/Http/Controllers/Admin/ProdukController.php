<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori; // Tambahkan Model Kategori
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        // Menggunakan with('kategori') agar query lebih efisien (Eager Loading)
        $produks = Produk::with('kategori')->latest()->paginate(10);
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown form
        $kategoris = Kategori::all();
        return view('admin.produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id', // Validasi kategori_id
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $file      = $request->file('gambar');
            $namaFile  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $namaFile);
            $data['gambar'] = $namaFile;
        }

        Produk::create($data);
        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        // Ambil semua kategori agar admin bisa mengubah kategori produk yang diedit
        $kategoris = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id', // Validasi kategori_id
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama kalau ada
            if ($produk->gambar) {
                $gambarLama = public_path('images/produk/' . $produk->gambar);
                if (file_exists($gambarLama)) {
                    unlink($gambarLama);
                }
            }
            $file      = $request->file('gambar');
            $namaFile  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $namaFile);
            $data['gambar'] = $namaFile;
        }

        $produk->update($data);
        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            $gambarLama = public_path('images/produk/' . $produk->gambar);
            if (file_exists($gambarLama)) {
                unlink($gambarLama);
            }
        }
        $produk->delete();
        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }
}