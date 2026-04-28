@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Toko Roti Ibu Ani')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
        <h4 class="fw-bold m-0 text-dark">Laporan Penjualan</h4>
    </div>
    <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold shadow-sm">
        <i class="bi bi-printer me-1"></i> CETAK LAPORAN
    </button>
</div>

{{-- FILTER FORM --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.laporan') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Pilih Bulan</label>
                <select name="bulan" class="form-select border-0 bg-light" style="border-radius: 10px; padding: 10px;">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$m,1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted text-uppercase">Tahun</label>
                <input type="number" name="tahun" class="form-control border-0 bg-light" value="{{ $tahun }}" style="border-radius: 10px; padding: 10px;">
            </div>
            <div class="col-md-2">
                <button class="btn text-white w-100 fw-bold shadow-sm" style="background-color: #8B4513; border-radius: 10px; padding: 10px;">
                    <i class="bi bi-filter me-1"></i> FILTER
                </button>
            </div>
        </form>
    </div>
</div>

{{-- STATISTIK RINGKASAN --}}
<div class="row mb-4 g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4" style="border-left: 5px solid #8B4513;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small text-uppercase fw-bold mb-2">Total Pendapatan</h6>
                        <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #fdf2e9; color: #8B4513;">
                        <i class="bi bi-cash-stack fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4" style="border-left: 5px solid #2e7d32;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small text-uppercase fw-bold mb-2">Pesanan Selesai</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $total_pesanan }} Transaksi</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #e8f5e9; color: #2e7d32;">
                        <i class="bi bi-bag-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TABEL DETAIL --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white py-3 border-0">
        <h6 class="fw-bold m-0 text-muted small text-uppercase"><i class="bi bi-list-check me-2"></i>Rincian Transaksi Periode Ini</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: #fdf2e9;">
                <tr>
                    <th class="ps-4 py-3 small text-muted text-uppercase border-0">Kode Pesanan</th>
                    <th class="py-3 small text-muted text-uppercase border-0">Nama Pelanggan</th>
                    <th class="py-3 small text-muted text-uppercase border-0 text-center">Tanggal & Waktu</th>
                    <th class="pe-4 py-3 small text-muted text-uppercase border-0 text-end">Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                <tr>
                    <td class="ps-4 py-3">
                        <code class="fw-bold text-primary">#{{ $pesanan->kode_pesanan }}</code>
                    </td>
                    <td class="fw-medium text-dark">{{ $pesanan->user->name }}</td>
                    <td class="text-center small">
                        <span class="d-block fw-bold">{{ $pesanan->created_at->format('d/m/Y') }}</span>
                        <span class="text-muted">{{ $pesanan->created_at->format('H:i') }} WIB</span>
                    </td>
                    <td class="pe-4 text-end fw-bold text-dark">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-file-earmark-x fs-1 d-block mb-2 opacity-25"></i>
                        Tidak ada data penjualan untuk periode yang dipilih.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if(!$pesanans->isEmpty())
            <tfoot style="background-color: #f8f9fa;">
                <tr>
                    <th colspan="3" class="ps-4 py-3 text-end text-muted small text-uppercase">Grand Total</th>
                    <th class="pe-4 py-3 text-end h5 fw-bold mb-0" style="color: #8B4513;">
                        Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
                    </th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

<style>
    /* Styling agar input terlihat rapi saat fokus */
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #8B4513 !important;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.1);
    }
    
    /* Hover Row Tabel */
    .table tbody tr:hover {
        background-color: #fffbf7 !important;
    }

    /* CSS Khusus Cetak */
    @media print {
        .navbar, .btn, form, footer { display: none !important; }
        .card { border: none !important; shadow: none !important; }
        body { padding-top: 0 !important; background: white !important; }
    }
</style>
@endsection