@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Toko Roti Ibu Ani')

@section('content')
<div class="container-fluid px-0 px-md-3 py-3 py-md-4">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-3 mb-md-4">
        <div style="width: 5px; height: 25px; background-color: #8B4513; border-radius: 10px;" class="me-2 me-md-3"></div>
        <h4 class="fw-bold m-0 text-dark fs-5 fs-md-4">Daftar Pesanan Masuk</h4>
    </div>

    {{-- VIEW DESKTOP: TABLE (Disembunyikan di Mobile) --}}
    <div class="card border-0 shadow-sm d-none d-lg-block" style="border-radius: 15px; overflow: hidden;">
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
                        <tr class="table-row-hover">
                            <td class="ps-4 py-3">
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
                                    $rawStatus = strtolower($pesanan->status);
                                    if ($rawStatus == 'selesai') {
                                        $st = ['color' => 'success', 'label' => 'Selesai'];
                                    } elseif ($rawStatus == 'dibatalkan') {
                                        $st = ['color' => 'danger', 'label' => 'Dibatalkan'];
                                    } else {
                                        // Segala status selain Selesai & Dibatalkan dianggap Menunggu Konfirmasi
                                        $st = ['color' => 'warning', 'label' => 'Menunggu'];
                                    }
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25" style="font-size: 0.75rem; width: 100px;">
                                    {{ strtoupper($st['label']) }}
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
                                   class="btn btn-sm text-white px-3 py-2 rounded-pill fw-bold btn-detail-custom" 
                                   style="background-color: #8B4513; border: none; font-size: 0.7rem; letter-spacing: 0.5px;">
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
    </div>

    {{-- VIEW MOBILE: CARD LIST (Hanya Muncul di Mobile/Tablet) --}}
    <div class="d-lg-none">
        <div class="row g-3">
            @forelse($pesanans as $pesanan)
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden card-mobile-hover">
                    {{-- Indikator Status Warna di Sisi Kiri Kartu --}}
                    @php 
                        $rawStatus = strtolower($pesanan->status);
                        if ($rawStatus == 'selesai') {
                            $st = ['color' => 'success', 'label' => 'Selesai'];
                        } elseif ($rawStatus == 'dibatalkan') {
                            $st = ['color' => 'danger', 'label' => 'Dibatalkan'];
                        } else {
                            $st = ['color' => 'warning', 'label' => 'Menunggu'];
                        }
                    @endphp
                    <div class="position-absolute top-0 bottom-0 start-0 bg-{{ $st['color'] }}" style="width: 4px;"></div>
                    
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <code class="fw-bold px-2 py-1 rounded" style="font-size: 0.8rem; background-color: #f8f9fa; color: #8B4513; border: 1px solid #e9ecef;">
                                #{{ $pesanan->kode_pesanan }}
                            </code>
                            <span class="badge rounded-pill px-3 py-1 bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25" style="font-size: 0.7rem;">
                                {{ strtoupper($st['label']) }}
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $pesanan->user->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-envelope me-1"></i> {{ $pesanan->user->email }}</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted" style="font-size: 0.7rem;">
                                <i class="bi bi-calendar-event me-1"></i> {{ $pesanan->created_at->format('d/m/Y') }}
                                <i class="bi bi-clock ms-2 me-1"></i> {{ $pesanan->created_at->format('H:i') }}
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-end pt-2 border-top border-light">
                            <div>
                                <span class="d-block text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">TOTAL HARGA</span>
                                <span class="fw-bold" style="color: #2E6B3A; font-size: 0.95rem;">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </span>
                            </div>
                            <a href="{{ route('admin.pesanan.show', $pesanan) }}" class="btn btn-sm text-white px-3 rounded-pill fw-bold btn-detail-custom" style="background-color: #8B4513; font-size: 0.7rem; padding-top: 0.4rem; padding-bottom: 0.4rem;">
                                <i class="bi bi-eye-fill me-1"></i> DETAIL
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center text-muted bg-white rounded-4 shadow-sm border-0">
                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                <h6 class="fw-bold text-dark">Belum Ada Pesanan</h6>
                <p class="small mb-0">Pesanan dari pelanggan akan muncul di sini.</p>
            </div>
            @endforelse
        </div>
    </div>
    
    {{-- BAGIAN PAGINATION --}}
    @if($pesanans->hasPages())
    <div class="card bg-white border-0 shadow-sm rounded-4 mt-3 mt-md-4">
        <div class="card-body py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-1 px-md-3">
                <div class="text-muted small mb-3 mb-md-0 fw-medium">
                    Menampilkan <span class="fw-bold text-dark">{{ $pesanans->firstItem() ?? 0 }}</span> 
                    sampai <span class="fw-bold text-dark">{{ $pesanans->lastItem() ?? 0 }}</span> 
                    dari <span class="fw-bold text-dark">{{ $pesanans->total() }}</span> pesanan
                </div>
                
                <div class="pagination-custom">
                    {{ $pesanans->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    /* Styling Dasar Tabel */
    .table > :not(caption) > * > * { border-bottom-width: 1px; border-color: #f8f9fa; vertical-align: middle; }
    .table-row-hover { transition: background-color 0.2s ease; }
    .table-row-hover:hover { background-color: #fffbf7 !important; }
    
    /* Tombol Detail Tema Bakery */
    .btn-detail-custom { transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(139, 69, 19, 0.1); }
    .btn-detail-custom:hover { background-color: #6b3410 !important; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(139, 69, 19, 0.3) !important; color: white !important; }

    /* Hover Animasi Card Mobile */
    .card-mobile-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .card-mobile-hover:active { transform: scale(0.98); box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important; }

    /* ====== PERBAIKAN PAGINATION ====== */
    .pagination-custom nav .flex.justify-between.flex-1 { display: none !important; }
    .pagination-custom nav .hidden.sm\:flex-1 { display: block !important; }
    .pagination-custom .pagination { margin-bottom: 0; gap: 5px; flex-wrap: wrap; justify-content: center; }
    .pagination-custom .page-item .page-link { border-radius: 8px !important; color: #8B4513; border: 1px solid #dee2e6; padding: 6px 12px; font-weight: 600; font-size: 0.8rem; transition: all 0.2s ease; }
    .pagination-custom .page-item.active .page-link { background-color: #8B4513 !important; border-color: #8B4513 !important; color: white !important; box-shadow: 0 4px 10px rgba(139, 69, 19, 0.2); }
    .pagination-custom .page-item .page-link:hover { background-color: #fdf2e9; border-color: #8B4513; color: #5D4037; }
    .pagination-custom .page-item.disabled .page-link { background-color: #f8f9fa; color: #adb5bd; border-color: #dee2e6; }

    /* Responsive Mobile Tweaks */
    @media (max-width: 768px) {
        .container-fluid { padding-top: 1rem !important; }
        /* Pagination lebih rapat di HP */
        .pagination-custom .page-item .page-link { padding: 4px 10px; font-size: 0.75rem; }
    }
</style>
@endsection