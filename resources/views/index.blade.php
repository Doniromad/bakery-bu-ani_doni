@extends('layouts.pelanggan')

@section('title', 'Selamat Datang di Bakery Bu Ani')

@section('content')

{{-- 1. HERO IMAGE BANNER --}}
<section class="mt-4 container">
    <div class="hero-banner-container shadow-sm border position-relative overflow-hidden" 
         style="background-image: url('{{ ($banner && $banner->gambar) ? asset('storage/banners/' . $banner->gambar) : 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1200&auto=format&fit=crop' }}'); 
                border-radius: 24px; height: 400px; background-size: cover; background-position: center;">
        
        <div class="position-absolute inset-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.3);"></div>
        
        <div class="hero-text-overlay text-center position-relative z-1 d-flex flex-column align-items-center justify-content-center h-100 px-3 text-white">
            <h1 class="fw-bold text-uppercase display-4 mb-2" style="font-family: 'Playfair Display', serif; text-shadow: 2px 2px 10px rgba(0,0,0,0.5);">
                {{ $banner->judul ?? 'Bakery Bu Ani' }}
            </h1>
            <p class="text-uppercase small mb-4" style="letter-spacing: 3px; opacity: 0.9;">
                {{ $banner->deskripsi ?? 'Sajian roti hangat dan segar setiap hari' }}
            </p>
            <a href="{{ route('pelanggan.produk.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow">MULAI BELANJA</a>
        </div>
    </div>
</section>

{{-- 2. PRODUK TERBARU (Gaya Premium, Ukuran Pas) --}}
<section class="container mt-5 pt-3">
    {{-- Header Section yang Lebih Elegan --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-pill me-3" style="width: 6px; height: 32px;"></div>
            <h4 class="fw-bold m-0 text-dark" style="font-family: 'Instrument Sans', sans-serif;">
                Produk Terbaru
            </h4>
        </div>
        {{-- Link Lihat Semua di Pojok Kanan Atas (Gaya Desktop) --}}
        <a href="{{ route('pelanggan.produk.index') }}" class="text-decoration-none small fw-bold text-primary d-none d-md-block btn-hover-arrow">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    {{-- Grid Diubah ke 4 Kolom di Desktop agar Ukuran Gambar Pas dan Proporsional --}}
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
        @forelse($produks as $produk)
        <div class="col">
            {{-- Seluruh Card dibungkus tag <a> agar bisa diklik, Menghapus Tombol Detail Besar --}}
            <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="text-decoration-none text-dark group">
                <div class="card h-100 product-card-beranda border-0 shadow-sm overflow-hidden">
                    
                    {{-- Image Wrapper 1:1 (Menjamin Gambar Selalu Kotak Sempurna) --}}
                    <div class="image-box-wrapper">
                        @if($produk->gambar)
                            <img src="{{ asset('images/produk/' . $produk->gambar) }}" class="img-fluid product-image" alt="{{ $produk->nama_produk }}">
                        @else
                            <div class="placeholder-img-bg"><i class="bi bi-image"></i></div>
                        @endif
                        
                        {{-- Badge Kategori yang Lebih Halus --}}
                        <span class="badge-category-wire">
                            {{ $produk->kategori->nama ?? 'Roti' }}
                        </span>

                        {{-- Overlay Hover Tipis --}}
                        <div class="image-overlay-hover"></div>
                    </div>

                    {{-- Body Card --}}
                    <div class="card-body p-3 d-flex flex-column text-center">
                        {{-- Judul Produk (Maks 2 Baris) --}}
                        <h6 class="product-name-wire mb-1 text-truncate-2">
                            {{ $produk->nama_produk }}
                        </h6>
                        
                        {{-- Harga --}}
                        <div class="product-price-wire mt-auto text-primary fw-bold">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- Footer Card (Stok & Terjual) --}}
                    <div class="card-footer bg-white border-0 px-3 pb-3 pt-0 text-muted d-flex justify-content-between align-items-center" style="font-size: 0.7rem;">
                        <span><i class="bi bi-box-seam me-1"></i> Stok {{ $produk->stok }}</span>
                    </div>

                </div>
            </a>
        </div>
        @empty
        <div class="col-12 py-5 text-center text-muted">
            <div class="bg-white p-5 rounded-5 shadow-sm border border-white">
                <i class="bi bi-patch-minus fs-1 d-block mb-3 opacity-25 text-primary"></i>
                <h5 class="fw-bold text-dark">Belum ada produk terbaru</h5>
                <p class="mb-0">Cek kembali nanti untuk koleksi roti hangat kami.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Tombol Lihat Semua di Bawah (Hanya Muncul di Mobile) --}}
    <div class="text-center mt-5 d-md-none">
        <a href="{{ route('pelanggan.produk.index') }}" 
           class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold shadow-sm" 
           style="letter-spacing: 1px; font-size: 0.85rem;">
            LIHAT SEMUA <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
</section>

{{-- Tambahkan CSS ini di bagian <style> halaman Beranda kamu --}}
<style>
    /* === UPGRADE SECTION BERANDA === */
    body { background-color: #F8FAFC; }

    /* Gaya Card Beranda (Premium Soft-UI) */
    .product-card-beranda {
        background: white;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 20px !important;
        border: 1px solid rgba(255,255,255,0.8) !important;
    }

    /* Efek Hover: Naik dan Bayangan Halus */
    a.group:hover .product-card-beranda {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(74, 144, 226, 0.1) !important;
        border: 1px solid var(--primary-blue) !important;
    }

    /* Menjamin Gambar Kotak Sempurna (1:1) */
    .image-box-wrapper {
        position: relative;
        width: 100%;
        padding-top: 100%; /* Membuat rasio kotak */
        background: #f8fafc;
        overflow: hidden;
        border-radius: 20px 20px 0 0;
    }
    .product-image {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }
    
    /* Efek Zoom Gambar saat Hover */
    a.group:hover .product-image { transform: scale(1.1); }

    .image-overlay-hover {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.03);
        opacity: 0;
        transition: 0.3s;
    }
    a.group:hover .image-overlay-hover { opacity: 1; }

    .placeholder-img-bg {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem; color: #cbd5e1;
    }

    /* Badge Kategori Putih Elegan */
    .badge-category-wire {
        position: absolute;
        top: 15px; right: 15px;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(5px);
        color: var(--primary-blue);
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.6rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        z-index: 5;
    }

    /* Judul Produk (Maks 2 Baris) */
    .product-name-wire {
        color: var(--slate-dark);
        font-weight: 700;
        font-size: 0.85rem;
        line-height: 1.4;
        height: 2.8em; /* 1.4 x 2 baris */
    }

    .product-price-wire {
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
    }

    /* Gaya Text-Truncate 2 Baris */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Hover Arrow Animation */
    .btn-hover-arrow i { transition: 0.3s; }
    .btn-hover-arrow:hover i { transform: translateX(5px); }

    @media (max-width: 768px) {
        .image-box-wrapper { border-radius: 15px 15px 0 0; }
        .product-card-beranda { border-radius: 15px !important; }
        .product-price-wire { font-size: 1rem; }
    }
</style>

{{-- 3. VARIAN TERFAVORIT (Hanya produk paling banyak dibeli) --}}
<section class="container mt-5 pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div style="width: 5px; height: 30px; background-color: var(--primary-blue); border-radius: 10px;" class="me-3"></div>
            <h4 class="fw-bold m-0" style="color: var(--slate-dark); font-family: 'Playfair Display', serif;">Produk Favorit</h4>
        </div>
        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2" style="font-size: 0.7rem;">BEST SELLER</span>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4 text-center">
        @foreach($favorit_produks as $p) {{-- MENGGUNAKAN VARIABEL FAVORIT --}}
        <div class="col">
            <div class="card h-100 product-card-modern border-0 shadow-sm overflow-hidden">
                <a href="{{ route('pelanggan.produk.show', $p->id) }}" class="text-decoration-none">
                    <div class="image-box">
                        <img src="{{ asset('images/produk/' . $p->gambar) }}" class="img-fluid" alt="{{ $p->nama_produk }}">
                        <span class="badge-type bg-danger text-white">HOT</span>
                    </div>
                    <div class="card-body p-3">
                        <h6 class="product-name mb-1">{{ $p->nama_produk }}</h6>
                        <div class="product-price mb-2 text-primary">Rp{{ number_format($p->harga, 0, ',', '.') }}</div>
                        <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">
                        </small>
                    </div>
                </a>
                <div class="px-3 pb-3">
                    <a href="{{ route('pelanggan.produk.show', $p->id) }}" class="btn btn-primary-soft w-100 rounded-pill py-2">
                        LIHAT
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- 4. POINT SELLING (USP) --}}
<section class="container mt-5 py-5 border-top">
    <div class="row g-4 justify-content-center">
        @php
            $points = [
                ['icon' => 'bi-fire', 'title' => 'Freshly Baked', 'desc' => 'Dipanggang hangat setiap pagi.'],
                ['icon' => 'bi-award', 'title' => 'Bahan Premium', 'desc' => 'Hanya menggunakan bahan pilihan.'],
                ['icon' => 'bi-patch-check', 'title' => '100% Halal', 'desc' => 'Terjamin kebersihan & prosesnya.'],
                ['icon' => 'bi-truck', 'title' => 'Fast Delivery', 'desc' => 'Siap antar sampai depan pintu.']
            ];
        @endphp
        @foreach($points as $point)
        <div class="col-6 col-md-3 text-center">
            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" 
                 style="width: 70px; height: 70px; background-color: #fff; border: 2px solid var(--soft-blue);">
                <i class="bi {{ $point['icon'] }} fs-3 text-primary"></i>
            </div>
            <h6 class="fw-bold text-uppercase small mb-1">{{ $point['title'] }}</h6>
            <p class="text-muted mb-0" style="font-size: 0.75rem;">{{ $point['desc'] }}</p>
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

    /* PRODUCT CARD MODERN (SAMA DENGAN KATALOG) */
    .product-card-modern { 
        background: white; 
        transition: 0.3s ease; 
        border-radius: 20px !important; 
    }
    .product-card-modern:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 35px rgba(74, 144, 226, 0.12) !important; 
    }

    .image-box { 
        position: relative; 
        width: 100%; 
        padding-top: 100%; 
        background: #f8fafc; 
        overflow: hidden; 
    }
    .image-box img { 
        position: absolute; 
        top: 0; left: 0; width: 100%; height: 100%; 
        object-fit: cover; 
        transition: 0.5s; 
    }
    .product-card-modern:hover .image-box img { transform: scale(1.1); }
    
    .placeholder-img { 
        position: absolute; 
        top: 0; left: 0; width: 100%; height: 100%; 
        display: flex; align-items: center; justify-content: center; 
        font-size: 2rem; color: #cbd5e1; 
    }

    .badge-type { 
        position: absolute; 
        top: 12px; right: 12px; 
        background: rgba(255,255,255,0.95); 
        color: var(--primary-blue); 
        padding: 5px 12px; 
        border-radius: 50px; 
        font-size: 0.6rem; 
        font-weight: 800; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.05); 
    }

    .product-name { 
        color: var(--slate-dark); 
        font-weight: 700; 
        font-size: 0.85rem; 
        height: 2.4em; 
        overflow: hidden; 
        display: -webkit-box; 
        -webkit-line-clamp: 2; 
        -webkit-box-orient: vertical; 
    }
    .product-price { 
        color: var(--primary-blue); 
        font-weight: 800; 
        font-size: 1.05rem; 
    }

    .btn-primary-soft { 
        background-color: var(--soft-blue); 
        color: var(--primary-blue); 
        border: none; 
        font-weight: 800; 
        font-size: 0.7rem; 
        letter-spacing: 1px; 
        transition: 0.3s; 
    }
    .btn-primary-soft:hover { 
        background-color: var(--primary-blue); 
        color: white; 
    }

    .btn-primary { background-color: var(--primary-blue); border: none; }
    .btn-primary:hover { background-color: var(--dark-blue); }

    @media (max-width: 768px) {
        .product-card-modern { border-radius: 15px !important; }
        .hero-banner-container { height: 300px !important; }
        .display-4 { font-size: 2rem; }
    }
</style>

@endsection