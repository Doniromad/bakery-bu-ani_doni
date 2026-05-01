@extends('layouts.pelanggan')

@section('title', 'Selamat Datang di Bakery Bu Ani')

@section('content')

{{-- 1. HERO IMAGE BANNER --}}
<section class="mt-2 mt-md-4 container-fluid px-0 px-md-3">
    <div class="hero-banner-container position-relative overflow-hidden shadow-sm" 
         style="background-image: url('{{ ($banner && $banner->gambar) ? asset('storage/banners/' . $banner->gambar) : 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1200&auto=format&fit=crop' }}'); 
                background-size: cover; background-position: center;">
        
        <div class="position-absolute inset-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.35);"></div>
        
        <div class="hero-text-overlay text-center position-relative z-1 d-flex flex-column align-items-center justify-content-center h-100 px-3 text-white">
            <h1 class="fw-bold text-uppercase mb-2 hero-title" style="font-family: 'Playfair Display', serif; text-shadow: 2px 2px 10px rgba(0,0,0,0.6);">
                {{ $banner->judul ?? 'Bakery Bu Ani' }}
            </h1>
            <p class="text-uppercase small mb-3 mb-md-4 hero-subtitle" style="letter-spacing: 2px; opacity: 0.95;">
                {{ $banner->deskripsi ?? 'Sajian roti hangat dan segar setiap hari' }}
            </p>
            <a href="{{ route('pelanggan.produk.index') }}" class="btn btn-primary rounded-pill fw-bold shadow hero-btn">MULAI BELANJA</a>
        </div>
    </div>
</section>

{{-- 2. PRODUK TERBARU --}}
<section class="container px-3 mt-4 mt-md-5 pt-2">
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4 pb-2 border-bottom border-light">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-pill me-2" style="width: 5px; height: 25px;"></div>
            <h5 class="fw-bold m-0 text-dark section-title" style="font-family: 'Instrument Sans', sans-serif;">
                Produk Terbaru
            </h5>
        </div>
        <a href="{{ route('pelanggan.produk.index') }}" class="text-decoration-none small fw-bold text-primary d-none d-md-block btn-hover-arrow">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    {{-- Grid: 2 kolom (mobile), 3 kolom (tablet), 4 kolom (desktop) --}}
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-md-4">
        @forelse($produks as $produk)
        <div class="col">
            <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="text-decoration-none text-dark group">
                <div class="card h-100 product-card-beranda border-0 shadow-sm overflow-hidden">
                    <div class="image-box-wrapper">
                        @if($produk->gambar)
                            <img src="{{ asset('images/produk/' . $produk->gambar) }}" class="img-fluid product-image" alt="{{ $produk->nama_produk }}">
                        @else
                            <div class="placeholder-img-bg"><i class="bi bi-image"></i></div>
                        @endif
                        <span class="badge-category-wire text-truncate" style="max-width: 80%;">
                            {{ $produk->kategori->nama ?? 'Roti' }}
                        </span>
                        <div class="image-overlay-hover"></div>
                    </div>
                    
                    {{-- Perbaikan Padding untuk Mobile --}}
                    <div class="card-body p-2 p-md-3 d-flex flex-column text-center">
                        <h6 class="product-name-wire mb-1 text-truncate-2">
                            {{ $produk->nama_produk }}
                        </h6>
                        <div class="product-price-wire mt-auto text-primary fw-bold">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-0 px-2 px-md-3 pb-2 pt-0 text-muted d-flex justify-content-between align-items-center" style="font-size: 0.65rem;">
                        <span><i class="bi bi-box-seam me-1"></i> Stok {{ $produk->stok }}</span>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 py-4 text-center text-muted">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <i class="bi bi-patch-minus fs-1 d-block mb-2 opacity-25 text-primary"></i>
                <h6 class="fw-bold text-dark mb-1">Belum ada produk terbaru</h6>
            </div>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-4 d-md-none">
        <a href="{{ route('pelanggan.produk.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold shadow-sm" style="font-size: 0.8rem;">
            LIHAT SEMUA KAMI <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</section>

{{-- 3. VARIAN TERFAVORIT --}}
<section class="container px-3 mt-4 mt-md-5 pt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
        <div class="d-flex align-items-center">
            <div style="width: 5px; height: 25px; background-color: var(--primary-blue); border-radius: 10px;" class="me-2"></div>
            <h5 class="fw-bold m-0 section-title" style="color: var(--slate-dark); font-family: 'Playfair Display', serif;">Produk Favorit</h5>
        </div>
        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-2 py-1 badge-bestseller">BEST SELLER</span>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-2 g-md-4 text-center">
        @foreach($favorit_produks as $p)
        <div class="col">
            <div class="card h-100 product-card-modern border-0 shadow-sm overflow-hidden">
                <a href="{{ route('pelanggan.produk.show', $p->id) }}" class="text-decoration-none">
                    <div class="image-box">
                        <img src="{{ asset('images/produk/' . $p->gambar) }}" class="img-fluid" alt="{{ $p->nama_produk }}">
                        <span class="badge-type bg-danger text-white">HOT</span>
                    </div>
                    <div class="card-body p-2 p-md-3 d-flex flex-column justify-content-between h-100">
                        <div>
                            <h6 class="product-name mb-1">{{ $p->nama_produk }}</h6>
                            <div class="product-price mb-2 text-primary">Rp{{ number_format($p->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </a>
                <div class="px-2 px-md-3 pb-2 pb-md-3 mt-auto">
                    <a href="{{ route('pelanggan.produk.show', $p->id) }}" class="btn btn-primary-soft w-100 rounded-pill py-1 py-md-2 btn-sm-mobile">
                        LIHAT
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- 4. POINT SELLING (USP) --}}
<section class="container px-3 mt-4 mt-md-5 py-4 py-md-5 border-top">
    <div class="row g-3 justify-content-center">
        @php
            $points = [
                ['icon' => 'bi-fire', 'title' => 'Freshly Baked', 'desc' => 'Dipanggang hangat'],
                ['icon' => 'bi-award', 'title' => 'Bahan Premium', 'desc' => 'Bahan berkualitas'],
                ['icon' => 'bi-patch-check', 'title' => '100% Halal', 'desc' => 'Terjamin suci'],
                ['icon' => 'bi-truck', 'title' => 'Fast Delivery', 'desc' => 'Siap antar']
            ];
        @endphp
        @foreach($points as $point)
        <div class="col-6 col-md-3 text-center">
            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center shadow-sm usp-icon-box">
                <i class="bi {{ $point['icon'] }} text-primary usp-icon"></i>
            </div>
            <h6 class="fw-bold text-uppercase mb-1 usp-title">{{ $point['title'] }}</h6>
            <p class="text-muted mb-0 usp-desc">{{ $point['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

<style>
    :root {
        --primary-blue: #4A90E2;
        --dark-blue: #357ABD;
        --soft-blue: #F0F7FF;
        --slate-dark: #1E293B;
    }

    body { background-color: #F8FAFC; overflow-x: hidden; }

    /* UKURAN DESKTOP (Default) */
    .hero-banner-container { border-radius: 24px; height: 400px; }
    .hero-title { font-size: 3.5rem; }
    .hero-btn { padding: 0.8rem 2rem; font-size: 1rem; }
    
    .usp-icon-box { width: 70px; height: 70px; border: 2px solid var(--soft-blue); background-color: #fff; }
    .usp-icon { font-size: 2rem; }
    .usp-title { font-size: 0.85rem; }
    .usp-desc { font-size: 0.75rem; }
    
    .section-title { font-size: 1.5rem; }
    .badge-bestseller { font-size: 0.7rem; }

    /* Card Styling Desktop */
    .product-card-beranda, .product-card-modern { 
        background: white; transition: 0.3s ease; border-radius: 16px !important; border: 1px solid rgba(0,0,0,0.05);
    }
    a.group:hover .product-card-beranda, .product-card-modern:hover { 
        transform: translateY(-5px); box-shadow: 0 10px 20px rgba(74, 144, 226, 0.08) !important; 
    }

    .image-box-wrapper, .image-box { 
        position: relative; width: 100%; padding-top: 100%; background: #f8fafc; overflow: hidden; border-radius: 16px 16px 0 0; 
    }
    .product-image, .image-box img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    a.group:hover .product-image, .product-card-modern:hover .image-box img { transform: scale(1.08); }
    
    .badge-category-wire, .badge-type { 
        position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.95); color: var(--primary-blue); 
        padding: 4px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; z-index: 5;
    }
    .badge-type { background: #dc3545; color: white; }

    .product-name-wire, .product-name { 
        color: var(--slate-dark); font-weight: 700; font-size: 0.9rem; line-height: 1.3; height: 2.6em; 
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; 
    }
    .product-price-wire, .product-price { font-weight: 800; font-size: 1.05rem; }
    
    .btn-primary-soft { background-color: var(--soft-blue); color: var(--primary-blue); border: none; font-weight: 800; font-size: 0.75rem; transition: 0.3s; }
    .btn-primary-soft:hover { background-color: var(--primary-blue); color: white; }

    /* === RESPONSIVE KHUSUS MOBILE === */
    @media (max-width: 768px) {
        /* Bikin Banner Full Width di HP */
        .px-0 { padding-left: 0 !important; padding-right: 0 !important; }
        .hero-banner-container { border-radius: 0 !important; height: 220px; }
        .hero-title { font-size: 1.5rem !important; margin-bottom: 0.5rem !important; }
        .hero-subtitle { font-size: 0.6rem; letter-spacing: 1px; margin-bottom: 1rem !important; }
        .hero-btn { font-size: 0.75rem; padding: 0.4rem 1.2rem !important; }
        
        .section-title { font-size: 1.1rem !important; }
        .badge-bestseller { font-size: 0.55rem; padding: 0.2rem 0.5rem !important; }
        
        /* Pengecilan jarak antar kolom (Gutter) */
        .g-2 { --bs-gutter-x: 0.5rem; --bs-gutter-y: 0.5rem; }
        
        /* Card Responsif HP */
        .product-card-beranda, .product-card-modern { border-radius: 12px !important; }
        .image-box-wrapper, .image-box { border-radius: 12px 12px 0 0; }
        
        /* Pengecilan Font di dalam Card */
        .product-name-wire, .product-name { font-size: 0.75rem !important; height: 2.6em; margin-bottom: 0.2rem !important; }
        .product-price-wire, .product-price { font-size: 0.85rem !important; }
        .badge-category-wire, .badge-type { font-size: 0.5rem !important; padding: 3px 6px; top: 6px; right: 6px; }
        
        /* Tombol & Footer Card */
        .btn-sm-mobile { font-size: 0.65rem !important; padding: 0.25rem !important; }
        .card-footer { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
        
        /* Pengecilan USP */
        .usp-icon-box { width: 45px; height: 45px; border-width: 1px; margin-bottom: 0.5rem !important; }
        .usp-icon { font-size: 1.2rem; }
        .usp-title { font-size: 0.65rem; }
        .usp-desc { font-size: 0.55rem; }
    }
</style>

@endsection