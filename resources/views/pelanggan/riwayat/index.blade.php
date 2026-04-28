@extends('layouts.pelanggan')

@section('title', 'Riwayat Pesanan - Toko Roti Ibu Ani')

@section('content')
<div class="container py-5">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 50px; height: 50px;">
            <i class="bi bi-clock-history fs-4"></i>
        </div>
        <div class="ms-3">
            <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">Riwayat Pesanan</h4>
            <p class="text-muted small m-0">Pantau status pengiriman dan riwayat belanja roti kamu.</p>
        </div>
    </div>

    @if($pesanans->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
            <div class="card-body">
                <i class="bi bi-clipboard-x text-muted opacity-25" style="font-size: 5rem;"></i>
                <h5 class="fw-bold mt-4">Belum ada pesanan nih...</h5>
                <p class="text-muted mb-4">Sepertinya kamu belum pernah memesan roti lezat kami.</p>
                <a href="{{ route('home') }}#produk" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
                    Cek Produk Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
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
                                        // Mapping Nama Status & Badge agar sama dengan Admin
                                        $statusMap = [
                                            'pending' => 'Menunggu',
                                            'diproses' => 'Bukti Bayar',
                                            'dikirim' => 'Dikirim',
                                            'selesai' => 'Selesai',
                                            'dibatalkan' => 'Dibatalkan'
                                        ];
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
                                    <span class="badge rounded-pill px-3 py-2 bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25" style="font-size: 0.7rem;">
                                        <i class="bi bi-{{ $st['icon'] }} me-1"></i>
                                        {{ strtoupper($statusMap[$currentStatus] ?? $pesanan->status) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-center">
                                    <a href="{{ route('pelanggan.riwayat.show', $pesanan) }}" 
                                       class="btn btn-dark btn-sm px-4 rounded-pill fw-bold shadow-sm" style="font-size: 0.7rem; letter-spacing: 0.5px;">
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

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $pesanans->links() }}
        </div>
    @endif
</div>

<style>
    .order-row {
        transition: background-color 0.2s ease;
        border-left: 4px solid transparent;
    }

    .order-row:hover {
        background-color: #f8fbff !important;
        border-left: 4px solid var(--bs-primary);
    }

    .badge {
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .table > :not(caption) > * > * {
        border-bottom-width: 1px;
        border-color: #f0f3f7;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection