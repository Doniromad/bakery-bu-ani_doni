@extends('layouts.pelanggan')

@section('title', $produk->nama_produk . ' - Bakery Bu Ani')

@section('content')
<div class="container py-3 py-md-5">
    {{-- Breadcrumb responsif --}}
    <nav aria-label="breadcrumb" class="mb-3 mb-md-4">
        <ol class="breadcrumb small p-0 m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Detail Produk</li>
        </ol>
    </nav>

    <div class="row justify-content-center g-3 g-lg-5">
        
        {{-- SISI KIRI: Gambar Produk --}}
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white product-detail-card">
                <div class="position-relative" style="aspect-ratio: 1/1;">
                    @if($produk->gambar)
                        <img src="{{ asset('images/produk/'.$produk->gambar) }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover;"
                             alt="{{ $produk->nama_produk }}">
                    @else
                        <div class="w-100 h-100 bg-light d-flex flex-column align-items-center justify-content-center text-muted">
                            <i class="bi bi-image fs-1 mb-2"></i>
                            <span class="small fw-bold">NO IMAGE</span>
                        </div>
                    @endif
                    
                    <div class="position-absolute top-0 start-0 m-2 m-md-3">
                        <span class="badge bg-white text-primary rounded-pill px-3 py-2 shadow-sm fw-bold border-0" style="font-size: 0.6rem;">
                            {{ strtoupper($produk->kategori->nama ?? 'Varian Roti') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: Informasi & Form --}}
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 bg-transparent mt-2 mt-md-0">
                <div class="card-body p-0">
                    <h2 class="fw-bold text-dark mb-2 product-title">
                        {{ $produk->nama_produk }}
                    </h2>
                    
                    <div class="h3 fw-bold text-primary mb-3 product-price">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>

                    <div class="mb-4">
                        <label class="text-uppercase small fw-bold text-muted d-block mb-2" style="letter-spacing: 1px;">Deskripsi Produk</label>
                        <p class="text-muted product-description">
                            {{ $produk->deskripsi ?? 'Roti lezat yang dipanggang segar setiap hari menggunakan bahan premium untuk kualitas rasa terbaik bagi keluarga Anda.' }}
                        </p>
                    </div>

                    <hr class="border-light opacity-10 my-3 my-md-4">

                    @if($produk->stok > 0)
                        <form action="{{ route('pelanggan.keranjang.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            
                            <div class="row g-3 align-items-end">
                                {{-- Selector Jumlah --}}
                                <div class="col-12 col-sm-auto">
                                    <label class="small fw-bold text-muted text-uppercase mb-2 d-block">Jumlah Pesanan</label>
                                    <div class="d-flex align-items-center bg-white border rounded-pill p-1 shadow-sm qty-selector">
                                        <button class="btn btn-link text-dark p-0 px-3 border-0" type="button" onclick="decrement()">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                        <input type="number" id="qty-input" name="jumlah" class="form-control border-0 bg-transparent text-center fw-bold p-0" 
                                               value="1" min="1" max="{{ $produk->stok }}" readonly>
                                        <button class="btn btn-link text-dark p-0 px-3 border-0" type="button" onclick="increment()">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Stok Info --}}
                                <div class="col-12 col-sm-auto">
                                    <span class="small fw-bold text-success bg-success bg-opacity-10 px-3 py-2 rounded-pill d-inline-block">
                                        <i class="bi bi-box-seam me-1"></i> Tersedia: {{ $produk->stok }} Pcs
                                    </span>
                                </div>

                                {{-- Tombol Action --}}
                                <div class="col-12 mt-4">
                                    <div class="d-flex flex-column flex-sm-row gap-2">
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-3 fw-bold shadow-sm flex-grow-1 action-btn">
                                            <i class="bi bi-cart-plus me-2"></i> TAMBAH KE KERANJANG
                                        </button>
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-3 fw-bold action-btn">
                                            KEMBALI
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-light border-0 shadow-sm rounded-4 p-3 d-flex align-items-center">
                            <i class="bi bi-info-circle text-danger fs-4 me-3"></i>
                            <div class="small">
                                <strong class="text-danger d-block">Maaf, Stok Sedang Kosong!</strong>
                                Kami akan segera memanggang batch baru untuk Anda.
                            </div>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 mt-2 fw-bold action-btn">KEMBALI</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #F8FAFC; }
    .btn-primary { background-color: #4A90E2; border: none; }
    .btn-primary:hover { background-color: #357ABD; transform: translateY(-2px); transition: 0.3s; }
    
    .product-title { font-size: 1.75rem; line-height: 1.2; }
    .product-price { font-size: 1.5rem; }
    .product-description { line-height: 1.6; font-size: 0.9rem; }
    
    .qty-selector { width: 100%; max-width: 150px; }
    #qty-input { width: 50px; font-size: 1rem; }

    /* Hilangkan Spin Arrow pada Input Number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    @media (max-width: 768px) {
        .product-title { font-size: 1.5rem; }
        .product-price { font-size: 1.35rem; }
        .qty-selector { max-width: 100%; justify-content: space-between; }
        .action-btn { font-size: 0.8rem; padding: 0.8rem !important; }
        .product-detail-card { border-radius: 20px !important; }
    }
</style>

<script>
    const qtyInput = document.getElementById('qty-input');
    const maxStock = {{ $produk->stok ?? 0 }};

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