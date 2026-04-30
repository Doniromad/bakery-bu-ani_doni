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

        // LOGIKA TAMBAHAN: Jika status berubah jadi 'selesai', update kolom 'terjual' di tabel produk
        if ($request->status == 'selesai' && $pesanan->status !== 'selesai') {
            foreach ($pesanan->detailPesanan as $detail) {
                if ($detail->produk) {
                    // Menambah jumlah terjual berdasarkan kuantitas pesanan
                    $detail->produk->increment('terjual', $detail->jumlah);
                }
            }
        }

        $pesanan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }
}