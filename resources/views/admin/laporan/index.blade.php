@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Toko Roti Ibu Ani')

@section('content')
<div class="container-fluid px-0 px-md-3 py-2 py-md-4">
    {{-- Header Halaman --}}
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4 gap-3">
        <div class="d-flex align-items-center">
            <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-2 me-md-3"></div>
            <h4 class="fw-bold m-0 text-dark fs-5 fs-md-4">Laporan Penjualan</h4>
        </div>
        <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill px-4 py-2 fw-bold shadow-sm w-100 w-sm-auto">
            <i class="bi bi-printer me-1"></i> CETAK LAPORAN
        </button>
    </div>

    {{-- FILTER FORM --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <form method="GET" action="{{ route('admin.laporan') }}" class="row g-2 g-md-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label extra-small fw-bold text-muted text-uppercase">Pilih Bulan</label>
                    <select name="bulan" class="form-select border-0 bg-light py-2" style="border-radius: 10px;">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0,0,0,$m,1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label extra-small fw-bold text-muted text-uppercase">Tahun</label>
                    <input type="number" name="tahun" class="form-control border-0 bg-light py-2" value="{{ $tahun }}" style="border-radius: 10px;">
                </div>
                <div class="col-6 col-md-4">
                    <button class="btn text-white w-100 fw-bold shadow-sm py-2" style="background-color: #8B4513; border-radius: 10px;">
                        <i class="bi bi-filter me-1"></i> FILTER
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- STATISTIK RINGKASAN: 2 Kolom Sejajar di Mobile --}}
    <div class="row mb-4 g-2 g-md-4">
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-3 p-md-4 border-start border-5" style="border-color: #8B4513 !important;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted extra-small text-uppercase fw-bold mb-1 mb-md-2">Pendapatan</h6>
                            <h5 class="fw-bold mb-0 text-dark small-mobile">Rp{{ number_format($total_pendapatan, 0, ',', '.') }}</h5>
                        </div>
                        <div class="rounded-circle d-none d-md-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: #fdf2e9; color: #8B4513;">
                            <i class="bi bi-cash-stack fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-3 p-md-4 border-start border-5" style="border-color: #2e7d32 !important;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted extra-small text-uppercase fw-bold mb-1 mb-md-2">Selesai</h6>
                            <h5 class="fw-bold mb-0 text-dark small-mobile">{{ $total_pesanan }} Pesanan</h5>
                        </div>
                        <div class="rounded-circle d-none d-md-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: #e8f5e9; color: #2e7d32;">
                            <i class="bi bi-bag-check fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DETAIL --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0 border-bottom">
            <h6 class="fw-bold m-0 text-muted small text-uppercase"><i class="bi bi-list-check me-2"></i>Rincian Transaksi Periode Ini</h6>
        </div>
        
        {{-- VIEW DESKTOP: TABLE (Disembunyikan di Mobile) --}}
        <div class="table-responsive d-none d-lg-block">
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
                    <tr class="table-row-hover">
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
                        <td colspan="4" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- VIEW MOBILE: LIST (Hanya Muncul di Mobile/Tablet) --}}
        <div class="d-lg-none">
            @forelse($pesanans as $pesanan)
            <div class="p-3 border-bottom border-light">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <code class="fw-bold text-primary small">#{{ $pesanan->kode_pesanan }}</code>
                    <span class="text-muted extra-small">{{ $pesanan->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark small-mobile">{{ $pesanan->user->name }}</span>
                    <span class="fw-bold text-success" style="font-size: 0.9rem;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
            @empty
            <div class="p-5 text-center text-muted">
                <i class="bi bi-file-earmark-x fs-1 d-block mb-2 opacity-25"></i>
                Tidak ada data.
            </div>
            @endforelse
        </div>

        @if(!$pesanans->isEmpty())
        <div class="card-footer bg-light border-0 py-3">
            <div class="d-flex justify-content-between align-items-center px-1 px-md-3">
                <span class="fw-bold text-muted extra-small text-uppercase">Grand Total</span>
                <span class="h5 fw-bold mb-0" style="color: #8B4513;">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .extra-small { font-size: 0.65rem; letter-spacing: 1px; }
    .small-mobile { font-size: 0.85rem; }

    /* Styling Input */
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #8B4513 !important;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.1);
    }
    
    /* Hover Row Tabel Desktop */
    .table-row-hover { transition: background-color 0.2s ease; }
    .table-row-hover:hover { background-color: #fffbf7 !important; }

    /* CSS Khusus Cetak */
    @media print {
        .navbar, .btn, form, footer, aside, .sidebar-wrapper, .mobile-navbar { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .main-wrapper { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        body { padding-top: 0 !important; background: white !important; }
        .container-fluid { padding: 0 !important; }
        .d-lg-block { display: block !important; } /* Pastikan tabel muncul saat diprint walau di buka via HP */
        .d-lg-none { display: none !important; }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .main-content { padding: 70px 10px 20px 10px !important; }
        h5.small-mobile { font-size: 0.9rem !important; }
    }
</style>
@endsection