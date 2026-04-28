@extends('layouts.admin')

@section('content')

<div class="d-flex align-items-center mb-4">
    <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
    <h4 class="fw-bold m-0 text-dark">Ringkasan Dashboard</h4>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="card-body p-4" style="border-left: 5px solid #8B4513;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted small text-uppercase fw-bold">Total Produk</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ \App\Models\Produk::count() }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: #fdf2e9; color: #8B4513;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">Varian roti tersedia</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="card-body p-4" style="border-left: 5px solid #5d4037;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted small text-uppercase fw-bold">Total Pesanan</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ \App\Models\Pesanan::count() }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: #efebe9; color: #5d4037;">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">Semua transaksi</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="card-body p-4" style="border-left: 5px solid #ffa000;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted small text-uppercase fw-bold">Pesanan Pending</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ \App\Models\Pesanan::where('status','pending')->count() }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: #fff8e1; color: #ffa000;">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">Menunggu konfirmasi</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="card-body p-4" style="border-left: 5px solid #2e7d32;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted small text-uppercase fw-bold">Pelanggan</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ \App\Models\User::where('role','pelanggan')->count() }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: #e8f5e9; color: #2e7d32;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">User terdaftar</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark">Pesanan Terbaru</h6>
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm px-3 rounded-pill" style="border: 1px solid #8B4513; color: #8B4513; font-size: 0.75rem; font-weight: bold;">LIHAT SEMUA</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 small text-muted text-uppercase">Kode</th>
                                <th class="py-3 small text-muted text-uppercase">Pelanggan</th>
                                <th class="py-3 small text-muted text-uppercase">Total</th>
                                <th class="py-3 small text-muted text-uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Pesanan::with('user')->latest()->take(5)->get() as $pesanan)
                            <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.pesanan.show', $pesanan->id) }}'">
                                <td class="ps-4"><code>#{{ $pesanan->kode_pesanan }}</code></td>
                                <td class="fw-medium">{{ $pesanan->user->name }}</td>
                                <td class="fw-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @php $badges = ['pending'=>'warning','diproses'=>'info','dikirim'=>'primary','selesai'=>'success','dibatalkan'=>'danger'] @endphp
                                    <span class="badge bg-{{ $badges[$pesanan->status] }} rounded-pill" style="font-size: 0.7rem;">{{ ucfirst($pesanan->status) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark">Produk Terbaru</h6>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-sm btn-dark px-3 rounded-pill" style="font-size: 0.75rem; font-weight: bold; background-color: #8B4513; border: none;">KELOLA</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach(\App\Models\Produk::latest()->take(5)->get() as $produk)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0" style="border-bottom: 1px solid #f0f0f0 !important;">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; color: #8B4513;">
                                <i class="bi bi-box-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark mb-0 small">{{ $produk->nama_produk }}</div>
                                <small class="text-muted">Tersisa: {{ $produk->stok }} pcs</small>
                            </div>
                        </div>
                        <div class="text-end fw-bold small text-dark">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    /* Haluskan tampilan tabel */
    .table thead th { font-size: 0.7rem; letter-spacing: 0.5px; }
    .table tbody tr:hover { background-color: #fffbf2 !important; }
    
    /* Hover transisi tombol */
    .btn-outline-primary:hover { background-color: #8B4513; border-color: #8B4513; }
</style>

@endsection