@extends('layouts.pelanggan')

@section('content')

{{-- 1. HERO IMAGE BANNER --}}
{{-- Banner otomatis hilang saat pencarian agar hasil cari langsung terlihat --}}
@if(!request('search'))
<section class="container mt-4">
    <div class="hero-banner-container shadow-sm border" 
         style="background-image: url('{{ ($banner && $banner->gambar) ? asset('storage/banners/' . $banner->gambar) : 'https://via.placeholder.com/1200x400' }}');">
        <div class="hero-text-overlay text-center">
            <h1 class="fw-bold text-uppercase">{{ $banner->judul ?? 'Toko Roti Ibu Ani' }}</h1>
            <p class="small text-uppercase">{{ $banner->deskripsi ?? 'Sajian roti hangat dan segar setiap hari' }}</p>
        </div>
    </div>
</section>
@endif

{{-- 2. FILTER KATEGORI MODERN --}}
<section class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h6 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px; font-size: 0.9rem;">Filter Kategori</h6>
        <div class="text-muted small d-none d-md-block">Pilih kategori roti favoritmu</div>
    </div>

    <div class="category-wrapper">
        <div class="category-scroll">
            {{-- Tombol Semua Produk --}}
            <div class="category-item">
                <a href="{{ route('home') }}" class="text-decoration-none group-cat">
                    <div class="cat-circle-wire {{ !isset($kategori) ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i>
                    </div>
                    <span class="cat-label-wire">SEMUA</span>
                </a>
            </div>

            @foreach($global_kategoris as $cat)
    @php 
        $nama = Str::lower($cat->nama); 
        // Pilih ikon berdasarkan kata kunci
        if (Str::contains($nama, 'tawar')) {
            $icon = 'bi-layers-half'; 
        } elseif (Str::contains($nama, 'manis')) {
            $icon = 'bi-egg-fried';
        } elseif (Str::contains($nama, 'donat')) {
            $icon = 'bi-circle';
        } elseif (Str::contains($nama, 'kering')) {
            $icon = 'bi-bag-heart';
        } elseif (Str::contains($nama, 'pastry')) {
            $icon = 'bi-bag-check';
        } else {
            $icon = 'bi-patch-check';
        }
    @endphp
    <div class="category-item">
        <a href="{{ route('pelanggan.kategori', $cat->slug) }}" class="text-decoration-none group-cat">
            <div class="cat-circle-wire {{ isset($kategori) && $kategori->id == $cat->id ? 'active' : '' }}">
                {{-- Warna diganti menjadi abu-abu kecokelatan (#8d6e63) --}}
                <i class="bi {{ $icon }}" style="color: #8d6e63 !important;"></i>
            </div>
            <span class="cat-label-wire">{{ strtoupper($cat->nama) }}</span>
        </a>
    </div>
@endforeach
        </div>
    </div>
</section>

{{-- 3. PRODUK TERBARU --}}
<section class="container mt-5" id="produk">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary me-3" style="width: 5px; height: 30px; border-radius: 10px;"></div>
        <h5 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px;">
            {{ isset($kategori) ? 'Kategori: ' . $kategori->nama : 'Produk Terbaru' }}
        </h5>
    </div>

    {{-- Alert Hasil Pencarian --}}
    @if(request('search'))
        <div class="alert alert-white border shadow-sm mb-4 d-flex justify-content-between align-items-center mt-3" style="border-radius: 12px; border-left: 5px solid var(--primary-blue) !important;">
            <span><i class="bi bi-search text-primary me-2"></i> Hasil pencarian: <strong>"{{ request('search') }}"</strong></span>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Reset</a>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        @forelse($produks as $produk)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm card-wire-style overflow-hidden">
                <div class="card-img-top bg-light position-relative" style="height: 220px;">
                    @if($produk->gambar)
                        <img src="{{ asset('images/produk/' . $produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                    @else
                        <div class="text-muted small px-3 text-center d-flex align-items-center h-100 justify-content-center">1:1 GAMBAR PRODUK</div>
                    @endif
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-white text-dark opacity-75 shadow-sm small">{{ $produk->kategori->nama ?? 'Roti' }}</span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <h6 class="text-uppercase fw-bold mb-1" style="font-size: 0.85rem; height: 2.5rem; overflow: hidden;">{{ $produk->nama_produk }}</h6>
                    <p class="fw-bold mb-3 text-primary">RP {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="btn btn-dark w-100 rounded-3 py-2 fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Beli</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 py-5 text-center text-muted">
            <i class="bi bi-emoji-frown fs-1 d-block mb-2 opacity-50"></i>
            Maaf, saat ini produk tidak tersedia.
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $produks->links() }}
    </div>
</section>

{{-- 4. KUALITAS TERJAMIN (Dinamis dari Banner/Settings) --}}
<section class="container my-5 py-5 border-top">
    <div class="row g-0 bg-white border shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
            <h4 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px;">Kualitas Terjamin</h4>
            <p class="text-muted small" style="line-height: 1.8;">Kami menggunakan bahan-bahan pilihan berkualitas tinggi untuk setiap produk roti yang kami hasilkan. Dipanggang setiap hari untuk memastikan kesegaran di tangan Anda.</p>
            <div class="bg-primary mt-4" style="width: 80px; height: 6px; border-radius: 10px;"></div>
        </div>
        
        {{-- BAGIAN GAMBAR YANG BISA DIUPLOAD --}}
        <div class="col-md-6 position-relative" style="min-height: 350px;">
            @if($banner && $banner->gambar)
                {{-- Menampilkan gambar yang diupload lewat fitur banner --}}
                <img src="{{ asset('storage/banners/' . $banner->gambar) }}" 
                     class="w-100 h-100" 
                     style="object-fit: cover; position: absolute; top: 0; left: 0;">
            @else
                {{-- Placeholder jika belum ada gambar --}}
                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light" 
                     style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <i class="bi bi-patch-check display-1 text-primary opacity-25"></i>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    /* CSS CATEGORY SCROLL MODERN */
    .category-wrapper {
        overflow: hidden;
        padding: 10px 0;
    }
    .category-scroll {
        display: flex;
        gap: 25px;
        overflow-x: auto;
        padding-bottom: 15px;
        scrollbar-width: none;
        -ms-overflow-style: none;
        justify-content: center;
    }
    .category-scroll::-webkit-scrollbar { display: none; }
    @media (max-width: 768px) {
        .category-scroll { justify-content: flex-start; gap: 15px; }
    }
    .category-item { flex: 0 0 auto; text-align: center; }

    /* CSS LINGKARAN KATEGORI */
    .cat-circle-wire {
        width: 60px; height: 60px;
        border: 2px solid #eee;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: white;
        color: #888;
        font-size: 1.3rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin: 0 auto 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .cat-label-wire { font-size: 0.65rem; font-weight: 700; color: #555; letter-spacing: 0.5px; transition: 0.3s; }

    .group-cat:hover .cat-circle-wire, .cat-circle-wire.active {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
        color: white;
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(74, 144, 226, 0.3);
    }

    /* CARD STYLE UPGRADE */
    .card-wire-style { transition: 0.3s ease; border-radius: 15px !important; }
    .card-wire-style:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
</style>

@endsection