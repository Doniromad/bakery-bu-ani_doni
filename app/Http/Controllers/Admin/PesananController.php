<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index()
    {
        // Memuat relasi user agar nama pelanggan muncul di tabel index
        $pesanans = Pesanan::with('user')->latest()->paginate(10);
        return view('admin.pesanan.index', compact('pesanans'));
    }

    /**
     * Menampilkan detail pesanan beserta data pelanggan dan produknya.
     */
    public function show(Pesanan $pesanan)
    {
        // KUNCI: Memuat 'user' agar nomor telepon pelanggan bisa diakses di View Detail
        $pesanan->load('user', 'detailPesanan.produk');
        
        return view('admin.pesanan.show', compact('pesanan'));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan'
        ]);

        // ======================================================
        // LOGIKA PENJUALAN PRODUK YANG DISEMPURNAKAN
        // ======================================================
        
        // 1. Jika pesanan BARU SAJA ditandai 'selesai' -> TAMBAH TERJUAL
        if ($request->status == 'selesai' && $pesanan->status !== 'selesai') {
            foreach ($pesanan->detailPesanan as $detail) {
                if ($detail->produk) {
                    $detail->produk->increment('terjual', $detail->jumlah);
                }
            }
        }
        
        // 2. Jika pesanan TADINYA 'selesai' tapi sekarang diubah ke status lain 
        // (misal admin salah klik dan mengubahnya jadi batal/pending) -> KURANGI KEMBALI TERJUAL
        elseif ($pesanan->status == 'selesai' && $request->status !== 'selesai') {
            foreach ($pesanan->detailPesanan as $detail) {
                if ($detail->produk) {
                    // Pastikan nilai 'terjual' tidak minus
                    $sisaTerjual = max(0, $detail->produk->terjual - $detail->jumlah);
                    $detail->produk->update(['terjual' => $sisaTerjual]);
                }
            }
        }

        // ======================================================

        $pesanan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }
}