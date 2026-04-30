@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Toko Roti Ibu Ani')

@section('content')
<div class="d-flex align-items-center mb-4">
    <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
    <h4 class="fw-bold m-0 text-dark">Daftar Pesanan Masuk</h4>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #fdf2e9;">
                    <tr>
                        <th class="ps-4 py-3 text-muted text-uppercase small border-0" style="font-weight: 700;">Kode</th>
                        <th class="py-3 text-muted text-uppercase small border-0" style="font-weight: 700;">Pelanggan</th>
                        <th class="py-3 text-muted text-uppercase small border-0" style="font-weight: 700;">Total Harga</th>
                        <th class="py-3 text-muted text-uppercase small border-0 text-center" style="font-weight: 700;">Status</th>
                        <th class="py-3 text-muted text-uppercase small border-0 text-center" style="font-weight: 700;">Waktu Pesan</th>
                        <th class="pe-4 py-3 text-muted text-uppercase small border-0 text-center" style="font-weight: 700;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $pesanan)
                    <tr>
                        <td class="ps-4 py-4">
                            <code class="fw-bold px-2 py-1 rounded" style="font-size: 0.85rem; background-color: #f8f9fa; color: #8B4513; border: 1px solid #e9ecef;">
                                #{{ $pesanan->kode_pesanan }}
                            </code>
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $pesanan->user->name }}</div>
                            <div class="text-muted small d-flex align-items-center">
                                <i class="bi bi-envelope me-1"></i> {{ $pesanan->user->email }}
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold" style="color: #2E6B3A; font-size: 0.95rem;">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php 
                                $badges = [
                                    'pending'    => ['color' => 'warning', 'icon' => 'hourglass-split'],
                                    'diproses'   => ['color' => 'info',    'icon' => 'gear-fill'],
                                    'dikirim'    => ['color' => 'primary', 'icon' => 'truck'],
                                    'selesai'    => ['color' => 'success', 'icon' => 'check-circle-fill'],
                                    'dibatalkan' => ['color' => 'danger',  'icon' => 'x-circle-fill']
                                ];
                                $st = $badges[$pesanan->status] ?? ['color' => 'secondary', 'icon' => 'question'];
                            @endphp
                            <span class="badge rounded-pill px-3 py-2 bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25" style="font-size: 0.7rem; width: 105px;">
                                <i class="bi bi-{{ $st['icon'] }} me-1"></i> {{ strtoupper($pesanan->status) }}
                            </span>
                        </td>
                        <td class="text-center small">
                            <div class="text-dark fw-bold mb-1">{{ $pesanan->created_at->format('d/m/Y') }}</div>
                            <div class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.7rem;">
                                {{ $pesanan->created_at->format('H:i') }} WIB
                            </div>
                        </td>
                        <td class="pe-4 text-center">
                            <a href="{{ route('admin.pesanan.show', $pesanan) }}" 
                               class="btn btn-sm text-white px-3 py-2 rounded-pill fw-bold shadow-sm btn-detail-custom" 
                               style="background-color: #8B4513; border: none; font-size: 0.7rem; letter-spacing: 0.5px; transition: 0.3s;">
                                <i class="bi bi-eye-fill me-1"></i> DETAIL
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted bg-light">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                            <h6 class="fw-bold opacity-50">Belum Ada Pesanan Masuk</h6>
                            <p class="small opacity-50 mb-0">Pesanan dari pelanggan akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- BAGIAN PAGINATION YANG DIPERBAIKI --}}
    @if($pesanans->hasPages())
    <div class="card-footer bg-white border-top py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3">
            <div class="text-muted small mb-3 mb-md-0 fw-medium">
                Menampilkan <span class="fw-bold text-dark">{{ $pesanans->firstItem() ?? 0 }}</span> 
                sampai <span class="fw-bold text-dark">{{ $pesanans->lastItem() ?? 0 }}</span> 
                dari total <span class="fw-bold text-dark">{{ $pesanans->total() }}</span> pesanan
            </div>
            
            <div class="pagination-custom">
                {{-- Memaksa Laravel menggunakan view Bootstrap 5 --}}
                {{ $pesanans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    /* Hilangkan border default tabel */
    .table > :not(caption) > * > * {
        border-bottom-width: 1px;
        border-color: #f8f9fa;
        vertical-align: middle;
    }

    /* Efek Hover baris tabel */
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    .table tbody tr:hover {
        background-color: #fffbf7 !important; /* Krem sangat muda */
    }

    /* Tombol Detail Hover */
    .btn-detail-custom:hover {
        background-color: #5D4037 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(93, 64, 55, 0.3) !important;
    }

    /* ====== PERBAIKAN PAGINATION ====== */
    
    /* Sembunyikan pesan Tailwind default jika masih bocor */
    .pagination-custom nav .flex.justify-between.flex-1 {
        display: none !important; 
    }
    .pagination-custom nav .hidden.sm\:flex-1 {
        display: block !important;
    }

    .pagination-custom .pagination {
        margin-bottom: 0;
        gap: 5px; /* Jarak antar tombol */
    }

    .pagination-custom .page-item .page-link {
        border-radius: 8px !important; /* Membuat kotak membulat */
        color: #8B4513; /* Warna teks cokelat */
        border: 1px solid #dee2e6;
        padding: 8px 14px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease-in-out;
    }

    /* Warna Tombol Aktif */
    .pagination-custom .page-item.active .page-link {
        background-color: #8B4513 !important;
        border-color: #8B4513 !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(139, 69, 19, 0.2);
    }

    /* Efek Hover */
    .pagination-custom .page-item .page-link:hover {
        background-color: #fdf2e9;
        border-color: #8B4513;
        color: #5D4037;
    }

    /* Tombol Disabled (Prev/Next mentok) */
    .pagination-custom .page-item.disabled .page-link {
        background-color: #f8f9fa;
        color: #adb5bd;
        border-color: #dee2e6;
    }
</style>
@endsection