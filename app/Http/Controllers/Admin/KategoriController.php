<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|unique:kategoris,nama']);

        Kategori::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambah!');
    }

    public function update(Request $request, $id)
{
    // Validasi: unik di tabel kategoris, kolom nama, tapi abaikan ID ini ($id)
    $request->validate([
        'nama' => 'required|unique:kategoris,nama,' . $id,
    ]);
    
    $kategori = Kategori::findOrFail($id);
    
    $kategori->update([
        'nama' => $request->nama,
        'slug' => \Illuminate\Support\Str::slug($request->nama)
    ]);

    return redirect()->back()->with('success', 'Kategori berhasil diubah!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Cek jika kategori masih digunakan oleh produk
        if ($kategori->produks()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal hapus! Kategori masih digunakan oleh produk.');
        }

        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}