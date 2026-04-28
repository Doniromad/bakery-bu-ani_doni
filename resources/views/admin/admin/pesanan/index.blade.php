@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Toko Roti Ibu Ani')

@section('content')
<div class="d-flex align-items-center mb-4">
    <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
    <h4 class="fw-bold m-0 text-dark">Daftar Pesanan Masuk</h4>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #fdf2e9;">
                    <tr>
                        <th class="ps-4 py-3 text-muted text-uppercase small">Kode</th>
                        <th class="py-3 text-muted text-uppercase small">Pelanggan</th>
                        <th class="py-3 text-muted text-uppercase small">Waktu Transaksi</th>
                        <th class="py-3 text-muted text-uppercase small">Total Bayar</th>
                        <th class="py-3 text-muted text-uppercase small text-center">Status</th>
                        <th class="pe-4 py-3 text-muted text-uppercase small text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanans as $pesanan)
                    <tr>
                        <td class="ps-4">
                            <code class="fw-bold text-primary">#{{ $pesanan->kode_pesanan }}</code>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $pesanan->user->name }}</div>
                            <small class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $pesanan->user->email }}</small>
                        </td>
                        <td>
                            <div class="small text-dark">{{ $pesanan->created_at->format('d M Y') }}</div>
                            <small class="text-muted">{{ $pesanan->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            <span class="fw-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="text-center">
                            @php 
                                $badges = [
                                    'pending' => ['color' => 'warning', 'icon' => 'hourglass-split'],
                                    'diproses' => ['color' => 'info', 'icon' => 'gear-fill'],
                                    'dikirim' => ['color' => 'primary', 'icon' => 'truck'],
                                    'selesai' => ['color' => 'success', 'icon' => 'check-circle-fill'],
                                    'dibatalkan' => ['color' => 'danger', 'icon' => 'x-circle-fill']
                                ];
                                $st = $badges[$pesanan->status] ?? ['color' => 'secondary', 'icon' => 'question'];
                            @endphp
                            <span class="badge rounded-pill px-3 py-2 bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25" style="font-size: 0.7rem; width: 100px;">
                                <i class="bi bi-{{ $st['icon'] }} me-1"></i> {{ strtoupper($pesanan->status) }}
                            </span>
                        </td>
                        <td class="pe-4 text-center">
                            <a href="{{ route('admin.pesanan.show', $pesanan) }}" 
                               class="btn btn-sm btn-dark px-3 rounded-pill fw-bold shadow-sm" 
                               style="background-color: #8B4513; border: none; font-size: 0.75rem;">
                                <i class="bi bi-eye-fill me-1"></i> DETAIL
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
<div class="d-flex justify-content-center mt-4">
    <div class="pagination-custom">
        {{ $pesanans->links() }}
    </div>
</div>

<style>
    /* Styling Scrollbar Table untuk Mobile */
    .table-responsive::-webkit-scrollbar { height: 6px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #8B4513; border-radius: 10px; }
    
    .table tbody tr { transition: 0.2s; }
    .table tbody tr:hover { background-color: #fffbf7 !important; }
    
    .badge { font-weight: 800; letter-spacing: 0.5px; }

    /* Custom Pagination Theme */
    .pagination-custom .page-link { color: #8B4513; border: none; margin: 0 2px; border-radius: 8px; }
    .pagination-custom .page-item.active .page-link { background-color: #8B4513; color: white; }
</style>
@endsection