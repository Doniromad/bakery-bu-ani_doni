@extends('layouts.pelanggan')

@section('title', 'Riwayat Pesanan - Toko Roti Ibu Ani')

@section('content')
<div class="container py-4 py-md-5">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm me-3 header-icon-box">
            <i class="bi bi-clock-history fs-5 fs-md-4"></i>
        </div>
        <div>
            <h4 class="fw-bold m-0 text-uppercase fs-5 fs-md-4" style="letter-spacing: 1px;">Riwayat Pesanan</h4>
            <p class="text-muted small m-0" style="font-size: 0.75rem;">Pantau status pengiriman roti kamu.</p>
        </div>
    </div>

    @if($pesanans->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
            <div class="card-body">
                <i class="bi bi-clipboard-x text-muted opacity-25" style="font-size: 5rem;"></i>
                <h5 class="fw-bold mt-4 fs-6 fs-md-5">Belum ada pesanan nih...</h5>
                <p class="text-muted mb-4 small">Sepertinya kamu belum pernah memesan roti lezat kami.</p>
                <a href="{{ route('pelanggan.produk.index') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                    Cek Produk Sekarang
                </a>
            </div>
        </div>
    @else
        
        {{-- VIEW DESKTOP: MENGGUNAKAN TABEL (Disembunyikan di Mobile) --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 border-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-muted border-0">Kode Pesanan</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0">Tanggal</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0">Total Bayar</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted text-center border-0">Status</th>
                                <th class="pe-4 py-3 text-center text-uppercase small fw-bold text-muted border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanans as $pesanan)
                            <tr class="order-row">
                                <td class="ps-4 py-4">
                                    <span class="fw-bold text-dark">#{{ $pesanan->kode_pesanan }}</span>
                                </td>
                                <td class="text-muted small">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-calendar3 me-2 text-primary"></i> 
                                        {{ $pesanan->created_at->format('d M Y') }}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock me-2 text-primary"></i> 
                                        {{ $pesanan->created_at->format('H:i') }} WIB
                                    </div>
                                </td>
                                <td class="fw-bold text-primary">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @php 
                                        $statusMap = ['pending' => 'Menunggu','diproses' => 'Bukti Bayar','dikirim' => 'Dikirim','selesai' => 'Selesai','dibatalkan' => 'Dibatalkan'];
                                        $badges = [
                                            'pending' => ['color' => 'warning', 'icon' => 'hourglass-split'],
                                            'diproses' => ['color' => 'info', 'icon' => 'camera-fill'],
                                            'dikirim' => ['color' => 'primary', 'icon' => 'truck'],
                                            'selesai' => ['color' => 'success', 'icon' => 'check-circle-fill'],
                                            'dibatalkan' => ['color' => 'danger', 'icon' => 'x-circle-fill']
                                        ];
                                        $currentStatus = strtolower($pesanan->status);
                                        $st = $badges[$currentStatus] ?? ['color' => 'secondary', 'icon' => 'question-circle'];
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-2 bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25" style="font-size: 0.75rem;">
                                        <i class="bi bi-{{ $st['icon'] }} me-1"></i>
                                        {{ strtoupper($statusMap[$currentStatus] ?? $pesanan->status) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-center">
                                    <a href="{{ route('pelanggan.riwayat.show', $pesanan) }}" 
                                       class="btn btn-dark btn-sm px-4 rounded-pill fw-bold shadow-sm" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        DETAIL
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- VIEW MOBILE: MENGGUNAKAN CARD LIST (Hanya Muncul di Mobile) --}}
        <div class="d-md-none">
            <div class="row g-3">
                @foreach($pesanans as $pesanan)
                <div class="col-12">
                    <div class="card border border-light shadow-sm rounded-4 order-card-mobile position-relative overflow-hidden">
                        {{-- Garis Indikator Status di Samping Kiri --}}
                        @php 
                            $currentStatus = strtolower($pesanan->status);
                            $st = $badges[$currentStatus] ?? ['color' => 'secondary', 'icon' => 'question-circle'];
                        @endphp
                        <div class="position-absolute top-0 bottom-0 start-0 bg-{{ $st['color'] }}" style="width: 5px;"></div>
                        
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark fs-6" style="letter-spacing: 0.5px;">#{{ $pesanan->kode_pesanan }}</span>
                                <span class="badge rounded-pill px-2 py-1 bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25" style="font-size: 0.6rem;">
                                    <i class="bi bi-{{ $st['icon'] }} me-1"></i> {{ strtoupper($statusMap[$currentStatus] ?? $pesanan->status) }}
                                </span>
                            </div>

                            <div class="text-muted mb-3" style="font-size: 0.75rem;">
                                <div class="mb-1"><i class="bi bi-calendar3 me-2 text-primary"></i>{{ $pesanan->created_at->format('d M Y') }}</div>
                                <div><i class="bi bi-clock me-2 text-primary"></i>{{ $pesanan->created_at->format('H:i') }} WIB</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-end pt-2 border-top border-light">
                                <div>
                                    <span class="d-block text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">TOTAL BAYAR</span>
                                    <span class="fw-bold text-primary fs-6">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('pelanggan.riwayat.show', $pesanan) }}" class="btn btn-dark btn-sm rounded-pill px-4 fw-bold" style="font-size: 0.7rem;">
                                    DETAIL
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 mt-md-5 d-flex justify-content-center">
            {{ $pesanans->links() }}
        </div>
    @endif
</div>

<style>
    /* Styling Desktop Table */
    .order-row { transition: background-color 0.2s ease; border-left: 4px solid transparent; }
    .order-row:hover { background-color: #f8fbff !important; border-left: 4px solid var(--bs-primary); }
    .table > :not(caption) > * > * { border-bottom-width: 1px; border-color: #f0f3f7; }
    .bg-light { background-color: #f8f9fa !important; }

    /* Styling Mobile Header Icon */
    .header-icon-box { width: 50px; height: 50px; }

    /* Styling Card Mobile */
    .order-card-mobile {
        background: #ffffff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .order-card-mobile:active {
        transform: scale(0.98);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .header-icon-box { width: 40px; height: 40px; }
        .container { padding-top: 1rem !important; }
        
        /* Modifikasi Pagination Laravel untuk HP agar tidak berantakan */
        .pagination { flex-wrap: wrap; justify-content: center; gap: 5px; }
        .page-link { padding: 0.3rem 0.6rem; font-size: 0.8rem; border-radius: 5px !important; }
        .page-item:first-child .page-link, .page-item:last-child .page-link { border-radius: 5px !important; }
    }
</style>
@endsection