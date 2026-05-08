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
        
        {{-- Grup Tombol Aksi (TEMA COKELAT SELARAS) --}}
        <div class="d-flex flex-row gap-2 btn-group-mobile">
            {{-- Tombol Kategori: Gaya Outline Cokelat --}}
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-brown-custom rounded-pill px-3 px-md-4 py-2 fw-bold shadow-sm flex-grow-1 flex-sm-grow-0">
                <i class="bi bi-grid-fill me-1 me-md-2"></i> KATEGORI
            </a>
            {{-- Tombol Tambah: Gaya Solid Cokelat --}}
            <a href="{{ route('admin.produk.create') }}" class="btn btn-brown-custom rounded-pill px-3 px-md-4 py-2 fw-bold shadow-sm flex-grow-1 flex-sm-grow-0">
                <i class="bi bi-plus-lg me-1 me-md-2"></i> TAMBAH
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- VIEW DESKTOP: TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 border-0">
                <thead style="background-color: #fdf2e9;">
                    <tr class="small text-muted text-uppercase">
                        <th class="ps-4 py-3 border-0">Produk</th>
                        <th class="py-3 border-0 text-center">Kategori</th>
                        <th class="py-3 border-0 text-center">Harga</th>
                        <th class="py-3 border-0 text-center">Stok</th>
                        <th class="pe-4 py-3 text-center border-0">Aksi</th>
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
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small bg-white"><i class="bi bi-image"></i></div>
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
                        <td class="fw-bold text-dark text-center small">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($produk->stok > 10)
                                <span class="text-success fw-bold small"><i class="bi bi-check-circle-fill me-1"></i>{{ $produk->stok }}</span>
                            @else
                                <span class="text-danger fw-bold small"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $produk->stok }}</span>
                            @endif
                        </td>
                        <td class="pe-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-light btn-sm rounded-circle shadow-sm p-2 hover-scale"><i class="bi bi-pencil-square text-info"></i></a>
                                <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Hapus produk?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm p-2 hover-scale"><i class="bi bi-trash3 text-danger"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- VIEW MOBILE: CARD LIST --}}
    <div class="d-md-none">
        <div class="row g-3">
            @foreach($produks as $produk)
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden product-card-mobile">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start">
                            <div class="rounded-3 bg-light overflow-hidden border flex-shrink-0" style="width: 70px; height: 70px;">
                                @if($produk->gambar)
                                    <img src="{{ asset('images/produk/'.$produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image fs-4"></i></div>
                                @endif
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">{{ $produk->nama_produk }}</h6>
                                    <span class="badge bg-soft-blue text-primary border-0 rounded-pill px-2 py-1" style="font-size: 0.6rem;">{{ $produk->kategori->nama ?? 'Roti' }}</span>
                                </div>
                                <div class="text-primary fw-bold mb-2" style="font-size: 0.85rem;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                    <div>
                                        <small class="text-muted d-block extra-small">STOK</small>
                                        <span class="{{ $produk->stok > 10 ? 'text-success' : 'text-danger' }} fw-bold small">{{ $produk->stok }} Pcs</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-light btn-sm rounded-3 px-3 py-2 border shadow-sm"><i class="bi bi-pencil-square text-info"></i></a>
                                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 px-3 py-2 border shadow-sm"><i class="bi bi-trash3 text-danger"></i></button>
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
    /* CSS TOMBOL TEMA SELARAS COKELAT */
    
    /* Tombol Solid Cokelat (TAMBAH) */
    .btn-brown-custom {
        background-color: #8B4513 !important;
        color: #ffffff !important;
        border: 2px solid #8B4513 !important;
        transition: all 0.3s;
    }
    .btn-brown-custom:hover {
        background-color: #6F3410 !important;
        border-color: #6F3410 !important;
        transform: translateY(-2px);
    }

    /* Tombol Outline Cokelat (KATEGORI) */
    .btn-outline-brown-custom {
        background-color: transparent !important;
        color: #8B4513 !important;
        border: 2px solid #8B4513 !important;
        transition: all 0.3s;
    }
    .btn-outline-brown-custom:hover {
        background-color: #fdf2e9 !important; /* Warna krem sangat muda saat hover */
        transform: translateY(-2px);
    }

    /* Pendukung UI lainnya */
    .bg-soft-blue { background-color: #F0F7FF; }
    .extra-small { font-size: 0.65rem; letter-spacing: 0.5px; }
    .product-row { transition: all 0.2s ease; border-left: 4px solid transparent; }
    .product-row:hover { background-color: #fdfaf8 !important; border-left: 4px solid #8B4513; }
    .table thead th { font-weight: 800; color: #8B4513 !important; font-size: 0.7rem; }
    .hover-scale:hover { transform: scale(1.15); background-color: #fff !important; }

    @media (max-width: 576px) {
        .btn-group-mobile { width: 100%; }
        .btn-group-mobile a { font-size: 0.7rem !important; padding: 10px 5px !important; }
        .container-fluid { padding-top: 1rem !important; }
    }
</style>
@endsection