@extends('layouts.admin')

@section('title', 'Kelola Produk - Toko Roti Ibu Ani')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
        <h4 class="fw-bold m-0 text-dark">Daftar Produk</h4>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="btn text-white px-4 shadow-sm fw-bold" style="background-color: #8B4513; border-radius: 10px;">
        <i class="bi bi-plus-lg me-2"></i>Tambah Produk Baru
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #fdf2e9;">
                    <tr>
                        <th class="ps-4 py-3 text-muted text-uppercase small">#</th>
                        <th class="py-3 text-muted text-uppercase small">Foto</th>
                        <th class="py-3 text-muted text-uppercase small">Nama Produk</th>
                        <th class="py-3 text-muted text-uppercase small">Harga</th>
                        <th class="py-3 text-muted text-uppercase small text-center">Stok</th>
                        <th class="pe-4 py-3 text-muted text-uppercase small text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $i => $produk)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $produks->firstItem() + $i }}</td>
                        <td>
                            <div class="rounded-3 overflow-hidden shadow-sm bg-light" style="width: 60px; height: 60px;">
                                @if($produk->gambar)
                                    <img src="{{ asset('images/produk/' . $produk->gambar) }}" 
                                         class="w-100 h-100" 
                                         style="object-fit: cover;" 
                                         alt="{{ $produk->nama_produk }}">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted" style="font-size: 1.5rem;">
                                        🍞
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-0">{{ $produk->nama_produk }}</div>
                            <small class="text-muted">{{ $produk->kategori->nama ?? 'Tanpa Kategori' }}</small>
                        </td>
                        <td class="fw-bold text-dark">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if($produk->stok <= 5)
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3">
                                    Hampir Habis: {{ $produk->stok }}
                                </span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">
                                    Tersedia: {{ $produk->stok }}
                                </span>
                            @endif
                        </td>
                        <td class="pe-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.produk.edit', $produk) }}" 
                                   class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold shadow-sm" 
                                   style="font-size: 0.75rem;">
                                    <i class="bi bi-pencil-square me-1"></i> EDIT
                                </a>
                                
                                <form action="{{ route('admin.produk.destroy', $produk) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $produk->nama_produk }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold shadow-sm" 
                                            style="font-size: 0.75rem;">
                                        <i class="bi bi-trash me-1"></i> HAPUS
                                    </button>
                                </form>
                            </div>
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
        {{ $produks->links() }}
    </div>
</div>

<style>
    /* Sinkronisasi warna pagination jika diperlukan */
    .pagination-custom .page-link {
        color: #8B4513;
        border-radius: 8px;
        margin: 0 3px;
        border: none;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .pagination-custom .page-item.active .page-link {
        background-color: #8B4513;
        border-color: #8B4513;
        color: white;
    }
    .table tbody tr:hover {
        background-color: #fffbf7 !important;
    }
    .badge {
        font-weight: 700;
        letter-spacing: 0.3px;
    }
</style>
@endsection