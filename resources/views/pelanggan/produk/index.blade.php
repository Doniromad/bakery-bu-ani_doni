@extends('layouts.pelanggan')

@section('title', 'Katalog Produk - Bakery Bu Ani')

@section('content')
<div class="container py-3 py-md-4">
    {{-- 1. BREADCRUMB (Konteks Navigasi) --}}
    <nav aria-label="breadcrumb" class="mb-3 mb-md-4 d-none d-md-block">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Produk</li>
        </ol>
    </nav>

    <div class="row g-3 g-md-4">
        {{-- 2. SIDEBAR FILTER (Tampil hanya di Desktop) --}}
        <aside class="col-lg-3 d-none d-lg-block">
            <div class="sticky-top" style="top: 110px; z-index: 10;">
                <div class="filter-card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                        <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i> Kategori
                    </h6>
                    <div class="category-list">
                        <a href="{{ route('pelanggan.produk.index') }}" 
                           class="cat-link {{ !isset($kategori) ? 'active' : '' }}">
                            Semua Produk
                        </a>
                        @foreach($global_kategoris as $cat)
                        <a href="{{ route('pelanggan.kategori', $cat->slug) }}" 
                           class="cat-link {{ isset($kategori) && $kategori->id == $cat->id ? 'active' : '' }}">
                            {{ $cat->nama }}
                        </a>
                        @endforeach
                    </div>

                    <hr class="my-4 opacity-50">
                    
                    <h6 class="fw-bold mb-3 text-dark">Roti Terbaru</h6>
                    <div class="latest-products">
                        @foreach($produks->take(3) as $tp)
                        <a href="{{ route('pelanggan.produk.show', $tp->id) }}" class="latest-item text-decoration-none">
                            <img src="{{ asset('images/produk/' . $tp->gambar) }}" class="rounded-3" alt="Roti">
                            <div class="latest-info">
                                <span class="name text-truncate d-block">{{ $tp->nama_produk }}</span>
                                <span class="price">Rp{{ number_format($tp->harga, 0, ',', '.') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

        {{-- 3. MAIN CONTENT --}}
        <div class="col-lg-9">
            
            {{-- Toolbar Atas (Diperbaiki: Tidak Melar di Desktop) --}}
            <div class="toolbar-premium mb-3 mb-md-4 bg-white p-3 rounded-4 shadow-sm">
                <div class="row align-items-center">
                    {{-- Judul & Info --}}
                    <div class="col-12 col-sm-6 text-center text-sm-start mb-3 mb-sm-0">
                        <h5 class="fw-bold m-0 text-dark fs-6 fs-sm-5">
                            {{ isset($kategori) ? $kategori->nama : 'Semua Koleksi' }}
                        </h5>
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Menampilkan {{ $produks->total() }} varian roti</small>
                    </div>
                    
                    {{-- Filter & Sort (Dikanankan di Desktop) --}}
                    <div class="col-12 col-sm-6">
                        <div class="d-flex justify-content-center justify-content-sm-end gap-2">
                            {{-- Tombol Filter (Hanya muncul di Mobile) --}}
                            <button class="btn btn-soft-primary d-lg-none rounded-pill px-3 fw-bold flex-grow-1 flex-sm-grow-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" style="font-size: 0.8rem;">
                                <i class="bi bi-funnel me-1"></i> FILTER
                            </button>
                            
                            {{-- PREMIUM CUSTOM DROPDOWN SORTING --}}
                            <form action="{{ url()->current() }}" method="GET" id="form-sorting" class="m-0 flex-grow-1 flex-sm-grow-0">
                                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                                <input type="hidden" name="sort" id="sort-value" value="{{ request('sort', 'terbaru') }}">

                                <div class="dropdown custom-dropdown-premium w-100">
                                    <button class="btn dropdown-toggle shadow-sm w-100 text-start text-sm-center dropdown-btn-adaptive" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-sort-down-alt me-1 text-primary"></i>
                                        <span id="selected-sort-text">
                                            @if(request('sort') == 'termurah') Termurah 
                                            @elseif(request('sort') == 'termahal') Termahal 
                                            @else Terbaru @endif
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 w-100 w-sm-auto">
                                        <li>
                                            <a class="dropdown-item {{ request('sort') == 'terbaru' || !request('sort') ? 'active' : '' }}" 
                                               href="javascript:void(0)" onclick="submitSort('terbaru')">
                                               <i class="bi bi-clock-history me-2"></i> Terbaru
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request('sort') == 'termurah' ? 'active' : '' }}" 
                                               href="javascript:void(0)" onclick="submitSort('termurah')">
                                               <i class="bi bi-graph-down me-2"></i> Harga Terendah
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request('sort') == 'termahal' ? 'active' : '' }}" 
                                               href="javascript:void(0)" onclick="submitSort('termahal')">
                                               <i class="bi bi-graph-up me-2"></i> Harga Tertinggi
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alert Pencarian --}}
            @if(request('search'))
                <div class="alert alert-white border shadow-sm mb-3 d-flex justify-content-between align-items-center rounded-4 p-2 p-md-3" style="border-left: 5px solid var(--primary-blue) !important;">
                    <span class="text-dark small"><i class="bi bi-search text-primary me-2"></i> Hasil: <strong>"{{ request('search') }}"</strong></span>
                    <a href="{{ route('pelanggan.produk.index') }}" class="btn btn-sm btn-light rounded-pill px-2 px-md-3" style="font-size: 0.7rem;">Hapus</a>
                </div>
            @endif

            {{-- Grid Produk (Mobile = 2 Kolom, Desktop = 4 Kolom) --}}
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-2 g-md-4">
                @forelse($produks as $produk)
                <div class="col">
                    <div class="card h-100 product-card-modern border-0 shadow-sm overflow-hidden">
                        <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="text-decoration-none">
                            <div class="image-box">
                                @if($produk->gambar)
                                    <img src="{{ asset('images/produk/' . $produk->gambar) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
                                @else
                                    <div class="placeholder-img"><i class="bi bi-image"></i></div>
                                @endif
                                <span class="badge-type text-truncate" style="max-width: 80%;">{{ $produk->kategori->nama ?? 'Roti' }}</span>
                            </div>
                            <div class="card-body p-2 p-md-3 d-flex flex-column">
                                <h6 class="product-name mb-1">{{ $produk->nama_produk }}</h6>
                                <div class="product-price mb-2 mt-auto">Rp{{ number_format($produk->harga, 0, ',', '.') }}</div>
                                <div class="d-flex justify-content-between align-items-center mt-2 border-top pt-2">
                                    <small class="text-muted" style="font-size: 0.65rem;"><i class="bi bi-box-seam me-1"></i> Stok {{ $produk->stok }}</small>
                                </div>
                            </div>
                        </a>
                        <div class="px-2 px-md-3 pb-2 pb-md-3">
                            <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="btn btn-primary-soft w-100 rounded-pill py-1 py-md-2 btn-sm-mobile">
                                DETAIL
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 py-5 text-center text-muted w-100">
                    <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mx-auto" style="max-width: 500px;">
                        <i class="bi bi-emoji-frown fs-1 d-block mb-3 opacity-25"></i>
                        <h6 class="fw-bold text-dark">Maaf, Roti Tidak Ditemukan</h6>
                        <p class="small mb-0">Coba kata kunci lain atau pilih kategori berbeda.</p>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4 mt-md-5 pagination-premium">
                {{ $produks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- OFFCANVAS FILTER (KHUSUS MOBILE) --}}
<div class="offcanvas offcanvas-start rounded-end-4" tabindex="-1" id="offcanvasFilter">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title fw-bold"><i class="bi bi-funnel me-2"></i> Filter Kategori</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="list-group list-group-flush">
            <a href="{{ route('pelanggan.produk.index') }}" class="list-group-item list-group-item-action border-0 px-2 py-3 {{ !isset($kategori) ? 'text-primary fw-bold bg-light rounded-3' : '' }}">Semua Produk</a>
            @foreach($global_kategoris as $cat)
            <a href="{{ route('pelanggan.kategori', $cat->slug) }}" class="list-group-item list-group-item-action border-0 px-2 py-3 {{ isset($kategori) && $kategori->id == $cat->id ? 'text-primary fw-bold bg-light rounded-3' : '' }}">{{ $cat->nama }}</a>
            @endforeach
        </div>
    </div>
</div>

<style>
    :root {
        --primary-blue: #4A90E2;
        --dark-blue: #357ABD;
        --soft-blue: #F0F7FF;
        --slate-dark: #1E293B;
    }

    body { background-color: #F8FAFC; overflow-x: hidden; }

    /* SIDEBAR STYLING */
    .filter-card { background: white; border: 1px solid #fff; }
    .cat-link { display: block; padding: 12px 0; color: #64748B; text-decoration: none; font-size: 0.9rem; transition: 0.3s; border-bottom: 1px solid #f8fafc; }
    .cat-link:hover, .cat-link.active { color: var(--primary-blue); padding-left: 8px; font-weight: 700; }
    
    .latest-item { display: flex; gap: 12px; margin-bottom: 15px; }
    .latest-item img { width: 45px; height: 45px; object-fit: cover; }
    .latest-info .name { font-size: 0.8rem; color: var(--slate-dark); font-weight: 600; }
    .latest-info .price { font-size: 0.75rem; color: var(--primary-blue); font-weight: 700; }

    /* CUSTOM DROPDOWN PREMIUM */
    .custom-dropdown-premium .btn { 
        background: white; 
        border: 1px solid #e2e8f0; 
        border-radius: 50px; 
        padding: 8px 15px; 
        color: var(--slate-dark); 
        transition: 0.3s; 
        white-space: nowrap; 
    }
    .custom-dropdown-premium .btn:hover { border-color: var(--primary-blue); background: var(--soft-blue); }
    .custom-dropdown-premium .dropdown-menu { border-radius: 12px; padding: 8px; min-width: 180px; }
    .custom-dropdown-premium .dropdown-item { border-radius: 8px; padding: 8px 15px; font-size: 0.8rem; font-weight: 600; }
    .custom-dropdown-premium .dropdown-item:hover { background-color: var(--soft-blue); color: var(--primary-blue); }
    .custom-dropdown-premium .dropdown-item.active { background-color: var(--primary-blue); color: white; }

    /* Fix Dropdown Lebar di Desktop */
    .dropdown-btn-adaptive { font-size: 0.85rem; min-width: 150px; }
    @media (min-width: 576px) {
        .dropdown-btn-adaptive { width: auto !important; }
    }

    /* PRODUCT CARD MODERN */
    .product-card-modern { background: white; transition: 0.3s ease; border-radius: 16px !important; border: 1px solid rgba(0,0,0,0.05); }
    .product-card-modern:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(74, 144, 226, 0.08) !important; }

    .image-box { position: relative; width: 100%; padding-top: 100%; background: #f8fafc; overflow: hidden; border-radius: 16px 16px 0 0; }
    .image-box img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .product-card-modern:hover .image-box img { transform: scale(1.08); }
    
    .badge-type { position: absolute; top: 8px; right: 8px; background: rgba(255,255,255,0.95); color: var(--primary-blue); padding: 4px 10px; border-radius: 50px; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; z-index: 5; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

    .product-name { color: var(--slate-dark); font-weight: 700; font-size: 0.85rem; line-height: 1.3; height: 2.6em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .product-price { color: var(--primary-blue); font-weight: 800; font-size: 1rem; }

    .btn-primary-soft { background-color: var(--soft-blue); color: var(--primary-blue); border: none; font-weight: 800; font-size: 0.7rem; transition: 0.3s; }
    .btn-primary-soft:hover { background-color: var(--primary-blue); color: white; }

    /* === RESPONSIVE MOBILE ADJUSTMENTS === */
    @media (max-width: 768px) {
        .container { padding-top: 1rem !important; }
        
        /* Flex Toolbars - Filter & Sort bersampingan */
        .toolbar-premium { padding: 0.8rem !important; }
        .btn-soft-primary { background-color: var(--soft-blue); color: var(--primary-blue); border: 1px solid #e0e9ff; }
        
        /* Pengecilan Jarak (Gutter) */
        .g-2 { --bs-gutter-x: 0.5rem; --bs-gutter-y: 0.5rem; }
        
        /* Modifikasi Card & Font Mobile */
        .product-card-modern { border-radius: 12px !important; }
        .image-box { border-radius: 12px 12px 0 0; }
        .badge-type { font-size: 0.5rem; padding: 3px 8px; top: 6px; right: 6px; }
        
        .product-name { font-size: 0.75rem; margin-bottom: 0.2rem !important; }
        .product-price { font-size: 0.85rem; }
        
        .btn-sm-mobile { font-size: 0.65rem; padding: 0.3rem !important; }
        
        /* Pagination Mobile */
        .pagination-premium .pagination { flex-wrap: wrap; justify-content: center; gap: 4px; }
        .pagination-premium .page-link { font-size: 0.8rem; padding: 0.3rem 0.6rem; border-radius: 6px !important; }
    }
</style>

<script>
    function submitSort(value) {
        document.getElementById('sort-value').value = value;
        document.getElementById('form-sorting').submit();
    }
</script>
@endsection