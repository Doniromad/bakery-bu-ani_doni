<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\SettingBank; // Pastikan Model ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', auth()->id())
            ->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('pelanggan.keranjang')->with('error', 'Keranjang kosong!');
        }

        // AMBIL DATA BANK UNTUK DITAMPILKAN DI VIEW
        $banks = SettingBank::where('is_active', true)->get();

        $total = $keranjangs->sum(fn($k) => $k->produk->harga * $k->jumlah);

        return view('pelanggan.checkout.index', compact('keranjangs', 'total', 'banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'metode_bayar'      => 'required|in:transfer,cod',
        ]);

        $keranjangs = Keranjang::with('produk')
            ->where('user_id', auth()->id())
            ->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('home')->with('error', 'Tidak ada item untuk di-checkout.');
        }

        $total = $keranjangs->sum(fn($k) => $k->produk->harga * $k->jumlah);

        // Gunakan Database Transaction agar data aman jika terjadi error di tengah jalan
        DB::beginTransaction();

        try {
            $pesanan = Pesanan::create([
                'user_id'           => auth()->id(),
                'kode_pesanan'      => 'TRB-' . date('Ymd') . strtoupper(substr(uniqid(), -5)),
                'total_harga'       => $total,
                'status'            => 'pending',
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_bayar'      => $request->metode_bayar,
            ]);

            foreach ($keranjangs as $item) {
                DetailPesanan::create([
                    'pesanan_id'   => $pesanan->id,
                    'produk_id'    => $item->produk_id,
                    'jumlah'       => $item->jumlah,
                    'harga_satuan' => $item->produk->harga,
                    'subtotal'     => $item->produk->harga * $item->jumlah,
                ]);

                // Opsional: Potong stok produk di sini jika diperlukan
                // $item->produk->decrement('stok', $item->jumlah);
            }

            // Hapus keranjang setelah checkout sukses
            Keranjang::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('pelanggan.riwayat')->with('success', 'Pesanan berhasil dibuat! Silahkan cek detail pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}