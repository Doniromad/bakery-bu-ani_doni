<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $pesanans = Pesanan::with('user', 'detailPesanan.produk')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->where('status', 'selesai')
            ->get();

        $total_pendapatan = $pesanans->sum('total_harga');
        $total_pesanan    = $pesanans->count();

        return view('admin.laporan.index', compact('pesanans', 'total_pendapatan', 'total_pesanan', 'bulan', 'tahun'));
    }
}