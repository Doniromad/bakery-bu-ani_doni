<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', auth()->id())
            ->get();
            
        $total = $keranjangs->sum(fn($k) => $k->produk->harga * $k->jumlah);
        
        return view('pelanggan.keranjang.index', compact('keranjangs', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah'    => 'required|integer|min:1' // Validasi jumlah dari input form
        ]);

        $keranjang = Keranjang::where('user_id', auth()->id())
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($keranjang) {
            // Tambahkan jumlah sesuai dengan yang diinput pelanggan di halaman detail
            $keranjang->increment('jumlah', $request->jumlah);
        } else {
            Keranjang::create([
                'user_id'   => auth()->id(),
                'produk_id' => $request->produk_id,
                'jumlah'    => $request->jumlah,
            ]);
        }

        // REDIRECT LANGSUNG KE HALAMAN KERANJANG (Bukan back())
        return redirect()->route('pelanggan.keranjang')->with('success', 'Produk berhasil ditambahkan! Silahkan periksa pesanan Anda.');
    }

    public function destroy(Keranjang $keranjang)
    {
        // Pastikan hanya pemilik yang bisa menghapus
        if ($keranjang->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        $keranjang->delete();
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}