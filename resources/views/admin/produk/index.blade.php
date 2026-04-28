@extends('layouts.admin')

@section('title', 'Kelola Produk - Toko Roti Ibu Ani')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        {{-- Aksen Garis Cokelat khas Toko Roti Ibu Ani --}}
        <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
        <h4 class="fw-bold m-0 text-dark text-uppercase" style="letter-spacing: 1px;">Daftar Produk</h4>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" style="background-color: #8B4513; border: none;">
        <i class="bi bi-plus-lg me-2"></i> TAMBAH PRODUK
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 border-0">
            <thead style="background-color: #fdf2e9;">
                <tr class="small text-muted text-uppercase">
                    <th class="ps-4 py-3 border-0" style="letter-spacing: 1px;">Produk</th>
                    <th class="py-3 border-0 text-center" style="letter-spacing: 1px;">Kategori</th>
                    <th class="py-3 border-0 text-center" style="letter-spacing: 1px;">Harga</th>
                    <th class="py-3 border-0 text-center" style="letter-spacing: 1px;">Stok</th>
                    <th class="pe-4 py-3 text-center border-0" style="letter-spacing: 1px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $produk)
                <tr class="product-row">
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-light overflow-hidden border shadow-sm" style="width: 55px; height: 55px;">
                                @if($produk->gambar)
                                    <img src="{{ asset('images/produk/'.$produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small bg-white">
                                        <i class="bi bi-image" style="font-size: 1.2rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-0 text-dark">{{ $produk->nama_produk }}</h6>
                                <small class="text-muted">ID: #PROD-{{ str_pad($produk->id, 3, '0', STR_PAD_LEFT) }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-soft-blue text-primary rounded-pill px-3 py-2 fw-bold" style="font-size: 0.7rem;">
                            {{ $produk->kategori->nama ?? 'Varian Roti' }}
                        </span>
                    </td>
                    <td class="fw-bold text-dark text-center">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @if($produk->stok > 10)
                            <div class="d-flex align-items-center justify-content-center text-success fw-bold">
                                <i class="bi bi-check-circle-fill me-1 small"></i> {{ $produk->stok }}
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center text-danger fw-bold">
                                <i class="bi bi-exclamation-triangle-fill me-1 small"></i> {{ $produk->stok }}
                            </div>
                        @endif
                    </td>
                    <td class="pe-4 text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-light btn-sm rounded-circle shadow-sm p-2" title="Edit Produk">
                                <i class="bi bi-pencil-square text-info fs-6"></i>
                            </a>
                            <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk {{ $produk->nama_produk }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm p-2" title="Hapus Produk">
                                    <i class="bi bi-trash3 text-danger fs-6"></i>
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

<style>
    .bg-soft-blue { background-color: #F0F7FF; }
    
    /* Menyamakan Hover dengan Detail Pesanan */
    .product-row {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }

    .product-row:hover {
        background-color: #fdfaf8 !important; /* Warna krem tipis saat hover */
        border-left: 4px solid #8B4513; /* Aksen cokelat di kiri saat hover */
    }

    .table thead th {
        font-weight: 800;
        color: #8B4513 !important;
    }

    .btn-light {
        background-color: #fff;
        border: 1px solid #f0f0f0;
    }

    .btn-light:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }
</style>
@endsection