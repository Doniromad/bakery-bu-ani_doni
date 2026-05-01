@extends('layouts.admin')

@section('content')

<div class="container-fluid px-0 px-md-2">
    {{-- Header Dashboard --}}
    <div class="d-flex align-items-center mb-3 mb-md-4">
        <div style="width: 5px; height: 25px; background-color: #8B4513; border-radius: 10px;" class="me-2 me-md-3"></div>
        <h5 class="fw-bold m-0 text-dark fs-5 fs-md-4">Ringkasan Dashboard</h5>
    </div>

    {{-- Kotak Statistik: 2 Kolom di HP (col-6), 4 Kolom di Desktop (col-md-3) --}}
    <div class="row g-2 g-md-4 mb-4">
        {{-- Total Produk --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 12px;">
                <div class="card-body p-3 p-md-4 border-start border-5" style="border-color: #8B4513 !important;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted extra-small text-uppercase fw-bold mb-1">Produk</h6>
                            <h3 class="fw-bold mb-0 text-dark fs-4 fs-md-2">{{ \App\Models\Produk::count() }}</h3>
                        </div>
                        <div class="rounded-circle d-none d-sm-flex align-items-center justify-content-center shadow-sm stat-icon" style="background-color: #fdf2e9; color: #8B4513;">
                            <i class="bi bi-box-seam fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Total Pesanan --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 12px;">
                <div class="card-body p-3 p-md-4 border-start border-5" style="border-color: #5d4037 !important;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted extra-small text-uppercase fw-bold mb-1">Pesanan</h6>
                            <h3 class="fw-bold mb-0 text-dark fs-4 fs-md-2">{{ \App\Models\Pesanan::count() }}</h3>
                        </div>
                        <div class="rounded-circle d-none d-sm-flex align-items-center justify-content-center shadow-sm stat-icon" style="background-color: #efebe9; color: #5d4037;">
                            <i class="bi bi-cart-check fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pesanan Pending --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 12px;">
                <div class="card-body p-3 p-md-4 border-start border-5" style="border-color: #ffa000 !important;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted extra-small text-uppercase fw-bold mb-1">Pending</h6>
                            <h3 class="fw-bold mb-0 text-dark fs-4 fs-md-2">{{ \App\Models\Pesanan::where('status','pending')->count() }}</h3>
                        </div>
                        <div class="rounded-circle d-none d-sm-flex align-items-center justify-content-center shadow-sm stat-icon" style="background-color: #fff8e1; color: #ffa000;">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pelanggan --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 12px;">
                <div class="card-body p-3 p-md-4 border-start border-5" style="border-color: #2e7d32 !important;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted extra-small text-uppercase fw-bold mb-1">User</h6>
                            <h3 class="fw-bold mb-0 text-dark fs-4 fs-md-2">{{ \App\Models\User::where('role','pelanggan')->count() }}</h3>
                        </div>
                        <div class="rounded-circle d-none d-sm-flex align-items-center justify-content-center shadow-sm stat-icon" style="background-color: #e8f5e9; color: #2e7d32;">
                            <i class="bi bi-people fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 g-md-4">
        {{-- Pesanan Terbaru --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark small-mobile">Pesanan Terbaru</h6>
                    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold" style="font-size: 0.65rem;">LIHAT SEMUA</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-muted text-uppercase" style="font-size: 0.65rem;">Kode</th>
                                    <th class="py-3 text-muted text-uppercase" style="font-size: 0.65rem;">Pelanggan</th>
                                    <th class="py-3 text-muted text-uppercase" style="font-size: 0.65rem;">Total</th>
                                    <th class="py-3 text-muted text-uppercase text-center" style="font-size: 0.65rem;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Pesanan::with('user')->latest()->take(5)->get() as $pesanan)
                                <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.pesanan.show', $pesanan->id) }}'">
                                    <td class="ps-4 small-mobile"><code>#{{ $pesanan->kode_pesanan }}</code></td>
                                    <td class="fw-medium small-mobile">{{ $pesanan->user->name }}</td>
                                    <td class="fw-bold small-mobile">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @php $badges = ['pending'=>'warning','diproses'=>'info','dikirim'=>'primary','selesai'=>'success','dibatalkan'=>'danger'] @endphp
                                        <span class="badge bg-{{ $badges[$pesanan->status] }} rounded-pill px-2" style="font-size: 0.6rem;">{{ ucfirst($pesanan->status) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produk Terbaru --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark small-mobile">Produk Terbaru</h6>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-sm text-white px-3 rounded-pill fw-bold" style="background-color: #8B4513; font-size: 0.65rem; border: none;">KELOLA</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\Produk::latest()->take(5)->get() as $produk)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-3 d-none d-sm-flex align-items-center justify-content-center me-2 me-md-3" style="width: 35px; height: 35px; color: #8B4513;">
                                    <i class="bi bi-box-fill" style="font-size: 0.8rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.75rem; max-width: 120px;">{{ $produk->nama_produk }}</div>
                                    <small class="text-muted" style="font-size: 0.65rem;">Stok: {{ $produk->stok }}</small>
                                </div>
                            </div>
                            <div class="text-end fw-bold text-dark" style="font-size: 0.75rem;">
                                Rp{{ number_format($produk->harga, 0, ',', '.') }}
                            </div>
                        </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Dasar Dashboard */
    .extra-small { font-size: 0.6rem; letter-spacing: 0.5px; }
    .stat-icon { width: 40px; height: 40px; }
    .table thead th { font-size: 0.65rem; letter-spacing: 0.5px; }
    .table tbody tr:hover { background-color: #fffbf2 !important; }
    .btn-outline-dark:hover { background-color: #8B4513; border-color: #8B4513; color: white; }

    /* Penyesuaian Khusus Mobile */
    @media (max-width: 768px) {
        .container-fluid { padding-bottom: 2rem; }
        .card-body { padding: 0.8rem !important; }
        .small-mobile { font-size: 0.75rem !important; }
        .fs-4 { font-size: 1.2rem !important; }
        
        /* Hilangkan padding berlebih pada grid tabel */
        .main-content { padding: 70px 8px 20px 8px !important; }
    }
</style>

@endsection