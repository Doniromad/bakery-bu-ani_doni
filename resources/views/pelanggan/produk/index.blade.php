@extends('layouts.pelanggan')

@section('title', 'Katalog Produk - Bakery Bu Ani')

@section('content')
<div class="container py-4">
    {{-- 1. BREADCRUMB (Konteks Navigasi) --}}
    <nav aria-label="breadcrumb" class="mb-4 d-none d-md-block">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Produk</li>
        </ol>
    </nav>

    <div class="row g-4">
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
            {{-- Toolbar Atas --}}
            <div class="toolbar-premium mb-4 d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm">
                <div class="toolbar-info">
                    <h5 class="fw-bold m-0 text-dark">
                        {{ isset($kategori) ? $kategori->nama : 'Semua Koleksi' }}
                    </h5>
                    <small class="text-muted">Menampilkan {{ $produks->total() }} varian roti</small>
                </div>
                
                <div class="d-flex gap-2 align-items-center">
                    {{-- Tombol Filter (Hanya muncul di Mobile) --}}
                    <button class="btn btn-soft-primary d-lg-none rounded-pill px-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter">
                        <i class="bi bi-sliders me-1"></i> Filter
                    </button>
                    
                    {{-- PREMIUM CUSTOM DROPDOWN SORTING --}}
                    <form action="{{ url()->current() }}" method="GET" id="form-sorting" class="m-0">
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        <input type="hidden" name="sort" id="sort-value" value="{{ request('sort', 'terbaru') }}">

                        <div class="dropdown custom-dropdown-premium">
                            <button class="btn dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-sort-down-alt me-2 text-primary"></i>
                                <span id="selected-sort-text">
                                    @if(request('sort') == 'termurah') Harga Terendah 
                                    @elseif(request('sort') == 'termahal') Harga Tertinggi 
                                    @else Urutkan: Terbaru @endif
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">
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

            {{-- Alert Pencarian --}}
            @if(request('search'))
                <div class="alert alert-white border shadow-sm mb-4 d-flex justify-content-between align-items-center rounded-4" style="border-left: 5px solid var(--primary-blue) !important;">
                    <span class="text-dark"><i class="bi bi-search text-primary me-2"></i> Hasil untuk: <strong>"{{ request('search') }}"</strong></span>
                    <a href="{{ route('pelanggan.produk.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Hapus</a>
                </div>
            @endif

            {{-- Grid Produk (4 Kolom di Desktop, 2 di Mobile) --}}
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-md-4">
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
                                <span class="badge-type">{{ $produk->kategori->nama ?? 'Roti' }}</span>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="product-name mb-1">{{ $produk->nama_produk }}</h6>
                                <div class="product-price mb-2">Rp{{ number_format($produk->harga, 0, ',', '.') }}</div>
                                <div class="d-flex justify-content-between align-items-center mt-2 border-top pt-2">
                                    <small class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-box-seam me-1"></i> Stok {{ $produk->stok }}</small>
                                    <small class="text-muted" style="font-size: 0.7rem;">Terjual 0</small>
                                </div>
                            </div>
                        </a>
                        <div class="px-3 pb-3">
                            <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="btn btn-primary-soft w-100 rounded-pill py-2">
                                DETAIL
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 py-5 text-center text-muted">
                    <div class="bg-white p-5 rounded-5 shadow-sm border border-white">
                        <i class="bi bi-emoji-frown fs-1 d-block mb-3 opacity-25"></i>
                        <h5 class="fw-bold text-dark">Maaf, Roti Tidak Ditemukan</h5>
                        <p>Coba kata kunci lain atau pilih kategori berbeda.</p>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5 pagination-premium">
                {{ $produks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- OFFCANVAS FILTER (KHUSUS MOBILE) --}}
<div class="offcanvas offcanvas-start rounded-end-4" tabindex="-1" id="offcanvasFilter">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold">Filter Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="list-group list-group-flush">
            <a href="{{ route('pelanggan.produk.index') }}" class="list-group-item list-group-item-action border-0 px-0 {{ !isset($kategori) ? 'text-primary fw-bold' : '' }}">Semua Produk</a>
            @foreach($global_kategoris as $cat)
            <a href="{{ route('pelanggan.kategori', $cat->slug) }}" class="list-group-item list-group-item-action border-0 px-0 {{ isset($kategori) && $kategori->id == $cat->id ? 'text-primary fw-bold' : '' }}">{{ $cat->nama }}</a>
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

    body { background-color: #F8FAFC; }

    /* SIDEBAR STYLING */
    .filter-card { background: white; border: 1px solid #fff; }
    .cat-link {
        display: block;
        padding: 12px 0;
        color: #64748B;
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.3s;
        border-bottom: 1px solid #f8fafc;
    }
    .cat-link:hover, .cat-link.active { color: var(--primary-blue); padding-left: 8px; font-weight: 700; }
    
    .latest-item {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
    }
    .latest-item img { width: 45px; height: 45px; object-fit: cover; }
    .latest-info .name { font-size: 0.8rem; color: var(--slate-dark); font-weight: 600; }
    .latest-info .price { font-size: 0.75rem; color: var(--primary-blue); font-weight: 700; }

    /* CUSTOM DROPDOWN PREMIUM */
    .custom-dropdown-premium .btn {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 8px 20px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--slate-dark);
        transition: 0.3s;
    }
    .custom-dropdown-premium .btn:hover { border-color: var(--primary-blue); background: var(--soft-blue); }
    .custom-dropdown-premium .dropdown-menu { border-radius: 15px; padding: 8px; min-width: 180px; box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .custom-dropdown-premium .dropdown-item { border-radius: 10px; padding: 10px 15px; font-size: 0.8rem; font-weight: 600; margin-bottom: 2px; }
    .custom-dropdown-premium .dropdown-item:hover { background-color: var(--soft-blue); color: var(--primary-blue); }
    .custom-dropdown-premium .dropdown-item.active { background-color: var(--primary-blue); color: white; }

    /* PRODUCT CARD MODERN */
    .product-card-modern { background: white; transition: 0.3s ease; border-radius: 20px !important; }
    .product-card-modern:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(74, 144, 226, 0.12) !important; }

    .image-box { position: relative; width: 100%; padding-top: 100%; background: #f8fafc; overflow: hidden; }
    .image-box img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .product-card-modern:hover .image-box img { transform: scale(1.1); }
    .placeholder-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #cbd5e1; }

    .badge-type { position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.95); color: var(--primary-blue); padding: 5px 12px; border-radius: 50px; font-size: 0.6rem; font-weight: 800; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }

    .product-name { color: var(--slate-dark); font-weight: 700; font-size: 0.85rem; height: 2.4em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .product-price { color: var(--primary-blue); font-weight: 800; font-size: 1.05rem; }

    .btn-primary-soft { background-color: var(--soft-blue); color: var(--primary-blue); border: none; font-weight: 800; font-size: 0.7rem; letter-spacing: 1px; transition: 0.3s; }
    .btn-primary-soft:hover { background-color: var(--primary-blue); color: white; }

    .btn-soft-primary { background-color: var(--soft-blue); color: var(--primary-blue); border: 1px solid #e0e9ff; font-weight: 600; font-size: 0.8rem; }

    @media (max-width: 768px) {
        .product-card-modern { border-radius: 15px !important; }
        .product-price { font-size: 0.95rem; }
        .toolbar-premium h5 { font-size: 1rem; }
    }
</style>

<script>
    function submitSort(value) {
        document.getElementById('sort-value').value = value;
        document.getElementById('form-sorting').submit();
    }
</script>
@endsection