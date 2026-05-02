<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::where('user_id', auth()->id())->latest()->paginate(10);
        return view('pelanggan.riwayat.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== auth()->id()) abort(403);
        $pesanan->load('detailPesanan.produk');
        return view('pelanggan.riwayat.show', compact('pesanan'));
    }

    /**
     * Fungsi untuk mengunggah bukti pembayaran
     */
    public function uploadBukti(Request $request, $id)
    {
        // 1. Validasi file (Maksimal 2MB)
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 2. Cari pesanan milik user yang login
        $pesanan = Pesanan::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            
            // Nama file unik: BUKTI_TRB-20260427XXXXX_1714213456.jpg
            $namaFile = 'BUKTI_' . $pesanan->kode_pesanan . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Folder tujuan di public/images/bukti_bayar
            $tujuanFolder = public_path('images/bukti_bayar');

            // Cek dan buat folder jika belum ada
            if (!File::isDirectory($tujuanFolder)) {
                File::makeDirectory($tujuanFolder, 0777, true, true);
            }

            // Hapus foto bukti lama dari folder jika pelanggan ingin ganti/re-upload
            if ($pesanan->bukti_bayar && File::exists($tujuanFolder . '/' . $pesanan->bukti_bayar)) {
                File::delete($tujuanFolder . '/' . $pesanan->bukti_bayar);
            }

            // Pindahkan file ke folder public
            $file->move($tujuanFolder, $namaFile);

            // 3. Update nama file DAN STATUS ke database
            $pesanan->update([
                'bukti_bayar' => $namaFile,
                'status'      => 'diproses' // <--- INI KUNCI PERBAIKANNYA
            ]);

            return back()->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi admin.');
        }

        return back()->with('error', 'Gagal memproses file gambar.');
    }
}