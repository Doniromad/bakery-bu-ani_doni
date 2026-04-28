<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::first(); 
        return view('admin.banner.index', compact('banner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $banner = Banner::first() ?? new Banner();

        if ($request->hasFile('gambar')) {
            // 1. Hapus gambar lama dari disk 'public' jika ada
            if ($banner->gambar && Storage::disk('public')->exists('banners/' . $banner->gambar)) {
                Storage::disk('public')->delete('banners/' . $banner->gambar);
            }

            // 2. Olah nama file baru
            $filename = time() . '.' . $request->gambar->getClientOriginalExtension();
            
            // 3. Simpan ke folder 'banners' di dalam disk 'public'
            // Ini akan otomatis masuk ke: storage/app/public/banners/
            $request->file('gambar')->storeAs('banners', $filename, 'public');
            
            $banner->gambar = $filename;
        }

        $banner->judul = $request->judul;
        $banner->deskripsi = $request->deskripsi;
        $banner->save();

        return back()->with('success', 'Banner berhasil diperbarui!');
    }
}