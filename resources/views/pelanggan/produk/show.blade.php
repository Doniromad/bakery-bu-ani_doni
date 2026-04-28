@extends('layouts.pelanggan')

@section('title', $produk->nama_produk . ' - Toko Roti Ibu Ani')

@section('content')
<div class="container py-5">
    {{-- Breadcrumb: Biar navigasi makin pro --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home') }}#produk" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- SISI KIRI: Gambar Produk --}}
        <div class="col-lg-5">
            <div class="product-image-wrapper p-2 bg-white shadow-sm rounded-4 overflow-hidden">
                @if($produk->gambar)
                    <img src="{{ asset('images/produk/'.$produk->gambar) }}" 
                         class="img-fluid rounded-4 w-100" 
                         alt="{{ $produk->nama_produk }}"
                         style="object-fit: cover; min-height: 400px;">
                @else
                    <div class="bg-light rounded-4 d-flex flex-column align-items-center justify-content-center" 
                         style="min-height: 400px; color: #cbd5e1;">
                        <i class="bi bi-image fs-1 mb-2"></i>
                        <span class="small fw-bold uppercase">Gambar Belum Tersedia</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- SISI KANAN: Detail & Order Form --}}
        <div class="col-lg-7">
            <div class="ps-lg-3">
                {{-- Kategori & Stok Badge --}}
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-soft-blue text-primary px-3 py-2 rounded-pill small fw-bold">
                        {{ $produk->kategori->nama ?? 'Varian Roti' }}
                    </span>
                    @if($produk->stok > 0)
                        <span class="text-success small fw-bold">
                            <i class="bi bi-check-circle-fill me-1"></i> Stok Tersedia: {{ $produk->stok }}
                        </span>
                    @else
                        <span class="text-danger small fw-bold">
                            <i class="bi bi-x-circle-fill me-1"></i> Stok Habis
                        </span>
                    @endif
                </div>

                <h1 class="display-6 fw-bold mb-3 text-dark" style="font-family: 'Playfair Display', serif;">
                    {{ $produk->nama_produk }}
                </h1>

                <h3 class="text-primary fw-bold mb-4">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </h3>

                <hr class="opacity-10 my-4">

                <h6 class="fw-bold text-uppercase small mb-2" style="letter-spacing: 1px;">Deskripsi Produk</h6>
                <p class="text-muted mb-5" style="line-height: 1.8; font-size: 0.95rem;">
                    {{ $produk->deskripsi ?? 'Roti segar yang dibuat dengan bahan pilihan, tanpa pengawet, dan dipanggang setiap hari untuk menjaga kualitas rasa serta kelembutannya.' }}
                </p>

                @if($produk->stok > 0)
                    <form action="{{ route('pelanggan.keranjang.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-auto">
                                <label class="fw-bold small text-muted text-uppercase">Jumlah</label>
                                <div class="input-group mt-1" style="width: 140px;">
                                    <button class="btn btn-outline-secondary rounded-start-pill border-end-0" type="button" onclick="decrement()">-</button>
                                    <input type="number" id="qty-input" name="jumlah" class="form-control text-center bg-white border-x-0" value="1" min="1" max="{{ $produk->stok }}" readonly>
                                    <button class="btn btn-outline-secondary rounded-end-pill border-start-0" type="button" onclick="increment()">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold text-uppercase shadow-sm" style="font-size: 0.85rem; letter-spacing: 1px;">
                                <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                            </button>
                            
                        </div>
                    </form>
                @else
                    <div class="alert alert-soft-danger rounded-4 border-0 d-flex align-items-center p-3 mb-4">
                        <i class="bi bi-info-circle me-3 fs-4"></i>
                        <div>
                            <strong class="d-block">Maaf, Stok Habis!</strong>
                            <span class="small">Roti ini sedang dalam proses pemanggangan kembali. Cek lagi nanti ya!</span>
                        </div>
                    </div>
                    <a href="{{ route('home') }}#produk" class="btn btn-outline-secondary btn-lg px-5 py-3 rounded-pill fw-bold text-uppercase">
                        Kembali Cari Roti
                    </a>
                @endif

                {{-- Fitur Unggulan --}}
                <div class="row mt-5 g-3">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center small text-muted">
                            <i class="bi bi-truck me-2 text-primary fs-5"></i>
                            <span>Pengiriman Cepat</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center small text-muted">
                            <i class="bi bi-patch-check me-2 text-primary fs-5"></i>
                            <span>Bahan Premium</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center small text-muted">
                            <i class="bi bi-sun me-2 text-primary fs-5"></i>
                            <span>Selalu Segar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-blue { background-color: #F0F7FF; }
    .alert-soft-danger { background-color: #FFF5F5; color: #C53030; }
    .product-image-wrapper img { transition: transform 0.5s ease; }
    .product-image-wrapper:hover img { transform: scale(1.05); }
    
    /* Chrome, Safari, Edge, Opera: hilangkan spin wheel number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
</style>

<script>
    const qtyInput = document.getElementById('qty-input');
    const maxStock = {{ $produk->stok }};

    function increment() {
        let currentVal = parseInt(qtyInput.value);
        if (currentVal < maxStock) {
            qtyInput.value = currentVal + 1;
        }
    }

    function decrement() {
        let currentVal = parseInt(qtyInput.value);
        if (currentVal > 1) {
            qtyInput.value = currentVal - 1;
        }
    }
</script>
@endsection