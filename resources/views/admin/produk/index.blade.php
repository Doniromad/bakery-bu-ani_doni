@extends('layouts.admin')

@section('title', 'Kelola Produk - Toko Roti Ibu Ani')

@section('content')
<div class="container-fluid px-0 px-md-3 py-3 py-md-4">
    {{-- Header Halaman --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
        <div class="d-flex align-items-center">
            <div style="width: 5px; height: 25px; background-color: #8B4513; border-radius: 10px;" class="me-2 me-md-3"></div>
            <h4 class="fw-bold m-0 text-dark text-uppercase fs-5 fs-md-4" style="letter-spacing: 1px;">Daftar Produk</h4>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm btn-add-mobile" style="background-color: #8B4513; border: none; font-size: 0.85rem;">
            <i class="bi bi-plus-lg me-2"></i> TAMBAH PRODUK
        </a>
    </div>

    {{-- VIEW DESKTOP: TABLE (Disembunyikan di Mobile) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
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
                                <div class="rounded-3 bg-light overflow-hidden border shadow-sm flex-shrink-0" style="width: 50px; height: 50px;">
                                    @if($produk->gambar)
                                        <img src="{{ asset('images/produk/'.$produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small bg-white">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ms-3">
                                    <h6 class="fw-bold mb-0 text-dark small">{{ $produk->nama_produk }}</h6>
                                    <small class="text-muted extra-small">ID: #PROD-{{ $produk->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-soft-blue text-primary rounded-pill px-3 py-2 fw-bold" style="font-size: 0.65rem;">
                                {{ $produk->kategori->nama ?? 'Roti' }}
                            </span>
                        </td>
                        <td class="fw-bold text-dark text-center small">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if($produk->stok > 10)
                                <span class="text-success fw-bold small"><i class="bi bi-check-circle-fill me-1"></i>{{ $produk->stok }}</span>
                            @else
                                <span class="text-danger fw-bold small"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $produk->stok }}</span>
                            @endif
                        </td>
                        <td class="pe-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-light btn-sm rounded-circle shadow-sm p-2 hover-scale" title="Edit">
                                    <i class="bi bi-pencil-square text-info"></i>
                                </a>
                                <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $produk->nama_produk }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm p-2 hover-scale" title="Hapus">
                                        <i class="bi bi-trash3 text-danger"></i>
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

    {{-- VIEW MOBILE: CARD LIST (Hanya Muncul di Mobile) --}}
    <div class="d-md-none">
        <div class="row g-3">
            @foreach($produks as $produk)
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden product-card-mobile">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start">
                            {{-- Foto Produk --}}
                            <div class="rounded-3 bg-light overflow-hidden border flex-shrink-0" style="width: 70px; height: 70px;">
                                @if($produk->gambar)
                                    <img src="{{ asset('images/produk/'.$produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image fs-4"></i></div>
                                @endif
                            </div>
                            
                            {{-- Info Produk --}}
                            <div class="ms-3 flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">{{ $produk->nama_produk }}</h6>
                                    <span class="badge bg-soft-blue text-primary border-0 rounded-pill px-2 py-1" style="font-size: 0.6rem;">
                                        {{ $produk->kategori->nama ?? 'Roti' }}
                                    </span>
                                </div>
                                <div class="text-primary fw-bold mb-2" style="font-size: 0.85rem;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-light">
                                    {{-- Status Stok --}}
                                    <div>
                                        <small class="text-muted d-block extra-small">STOK</small>
                                        @if($produk->stok > 10)
                                            <span class="text-success fw-bold small">{{ $produk->stok }} Pcs</span>
                                        @else
                                            <span class="text-danger fw-bold small">{{ $produk->stok }} Pcs</span>
                                        @endif
                                    </div>
                                    
                                    {{-- Tombol Aksi Mobile --}}
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-light btn-sm rounded-3 px-3 py-2 border shadow-sm">
                                            <i class="bi bi-pencil-square text-info"></i>
                                        </a>
                                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $produk->nama_produk }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 px-3 py-2 border shadow-sm">
                                                <i class="bi bi-trash3 text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .bg-soft-blue { background-color: #F0F7FF; }
    .extra-small { font-size: 0.65rem; letter-spacing: 0.5px; }

    /* Hover Desktop */
    .product-row { transition: all 0.2s ease; border-left: 4px solid transparent; }
    .product-row:hover { background-color: #fdfaf8 !important; border-left: 4px solid #8B4513; }
    .table thead th { font-weight: 800; color: #8B4513 !important; font-size: 0.7rem; }

    /* Animasi Tombol */
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.15); background-color: #fff !important; }

    /* Card Mobile */
    .product-card-mobile { transition: transform 0.2s; }
    .product-card-mobile:active { transform: scale(0.98); }

    @media (max-width: 576px) {
        .btn-add-mobile { width: 100%; text-align: center; }
        .container-fluid { padding-top: 1rem !important; }
    }
</style>
@endsection