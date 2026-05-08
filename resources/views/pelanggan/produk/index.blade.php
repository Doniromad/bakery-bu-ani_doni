@extends('layouts.pelanggan')

@section('title', 'Katalog Produk - Bakery Bu Ani')

@section('content')
<div class="container py-3 py-md-5">
    {{-- 1. BREADCRUMB (Hanya Desktop) --}}
    <nav aria-label="breadcrumb" class="mb-3 mb-md-4 d-none d-lg-block">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Produk</li>
        </ol>
    </nav>

    <div class="row g-3 g-md-4">
        {{-- 2. SIDEBAR FILTER (Desktop Saja) --}}
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
                            {{-- Tambahkan wrapper gambar agar ukuran tetap konsisten --}}
                            <div class="latest-img-container">
                                <img src="{{ asset('images/produk/' . $tp->gambar) }}" class="rounded-3" alt="Roti">
                            </div>
                            <div class="latest-info">
                                <span class="name">{{ $tp->nama_produk }}</span>
                                <span class="price">Rp{{ number_format($tp->harga, 0, ',', '.') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

        {{-- 3. MAIN CONTENT AREA --}}
        <div class="col-lg-9">
            {{-- Toolbar Atas (Kategori & Sortir) --}}
            <div class="toolbar-premium mb-3 mb-md-4 bg-white p-2 p-md-3 rounded-4 shadow-sm border border-light">
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div class="flex-grow-1 min-w-0">
                        <h6 class="fw-bold m-0 text-dark text-truncate">
                            {{ isset($kategori) ? $kategori->nama : 'Semua' }}
                        </h6>
                    </div>

                    <div class="d-flex gap-2 align-items-center flex-shrink-0">
                        {{-- DROPDOWN KATEGORI (HANYA MOBILE) --}}
                        <div class="dropdown custom-dropdown-premium d-lg-none">
                            <button class="btn-pill-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-grid-fill text-primary"></i>
                                <span>Kategori</span>
                            </button>
                            <ul class="dropdown-menu border-0 shadow-lg mt-2 dropdown-menu-end">
                                <li><a class="dropdown-item {{ !isset($kategori) ? 'active' : '' }}" href="{{ route('pelanggan.produk.index') }}">Semua Produk</a></li>
                                @foreach($global_kategoris as $cat)
                                    <li><a class="dropdown-item {{ isset($kategori) && $kategori->id == $cat->id ? 'active' : '' }}" href="{{ route('pelanggan.kategori', $cat->slug) }}">{{ $cat->nama }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- DROPDOWN SORTING --}}
                        <form action="{{ url()->current() }}" method="GET" id="form-sorting" class="m-0">
                            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                            <input type="hidden" name="sort" id="sort-value" value="{{ request('sort', 'terbaru') }}">

                            <div class="dropdown custom-dropdown-premium">
                                <button class="btn-pill-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-sort-down-alt text-primary"></i>
                                    <span>
                                        @if(request('sort') == 'termurah') Termurah
                                        @elseif(request('sort') == 'termahal') Termahal
                                        @else Terbaru @endif
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">
                                    <li><a class="dropdown-item {{ request('sort') == 'terbaru' || !request('sort') ? 'active' : '' }}" href="javascript:void(0)" onclick="submitSort('terbaru')">Terbaru</a></li>
                                    <li><a class="dropdown-item {{ request('sort') == 'termurah' ? 'active' : '' }}" href="javascript:void(0)" onclick="submitSort('termurah')">Harga Terendah</a></li>
                                    <li><a class="dropdown-item {{ request('sort') == 'termahal' ? 'active' : '' }}" href="javascript:void(0)" onclick="submitSort('termahal')">Harga Tertinggi</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Grid Produk --}}
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-2 g-md-4">
                @forelse($produks as $produk)
                <div class="col">
                    <div class="card h-100 product-card-modern border-0 shadow-sm overflow-hidden">
                        <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="text-decoration-none">
                            <div class="image-box">
                                <img src="{{ asset('images/produk/' . $produk->gambar) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
                                <span class="badge-type text-truncate">{{ $produk->kategori->nama ?? 'Roti' }}</span>
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
                            <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="btn btn-primary-soft w-100 rounded-pill py-1 py-md-2 btn-sm-mobile">DETAIL</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 py-5 text-center text-muted w-100">
                    <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mx-auto" style="max-width: 500px;">
                        <i class="bi bi-emoji-frown fs-1 d-block mb-3 opacity-25"></i>
                        <h6 class="fw-bold text-dark">Maaf, Roti Tidak Ditemukan</h6>
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

<style>
    :root {
        --primary-blue: #4A90E2;
        --soft-blue: #F0F7FF;
        --slate-dark: #1E293B;
        --text-slate: #64748b;
    }

    body { background-color: #F8FAFC; overflow-x: hidden; }

    /* === PERBAIKAN SIDEBAR (TULISAN KELUAR CARD) === */
    .latest-item { 
        display: flex; 
        gap: 12px; 
        margin-bottom: 15px; 
        align-items: center; 
        overflow: hidden; 
    }
    .latest-img-container { 
        width: 45px; 
        height: 45px; 
        flex-shrink: 0; /* Gambar tidak boleh mengecil */
    }
    .latest-img-container img { width: 100%; height: 100%; object-fit: cover; }
    
    .latest-info { 
        flex-grow: 1; 
        min-width: 0; /* KUNCI: Supaya flex item bisa mengecil dan memicu truncation */
    }
    .latest-info .name { 
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--slate-dark);
        /* Potong teks jika kepanjangan */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .latest-info .price { font-size: 0.75rem; color: var(--primary-blue); font-weight: 600; }

    /* CSS LAINNYA */
    .filter-card { background: white; border: 1px solid #eee; }
    .cat-link { display: block; padding: 10px 15px; color: #64748B; text-decoration: none; font-size: 0.9rem; transition: 0.3s; border-radius: 10px; margin-bottom: 5px; }
    .cat-link:hover, .cat-link.active { background: var(--soft-blue); color: var(--primary-blue); font-weight: 700; }
    
    .btn-pill-dropdown { display: inline-flex; align-items: center; gap: 6px; background: white; border: 1px solid #e2e8f0; border-radius: 999px; padding: 7px 14px; font-size: 12px; font-weight: 700; color: #1e293b; white-space: nowrap; transition: 0.2s; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
    .btn-pill-dropdown:hover { border-color: var(--primary-blue); background: var(--soft-blue); }
    .btn-pill-dropdown::after { display: none !important; }

    .custom-dropdown-premium .dropdown-menu { border-radius: 12px; padding: 6px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.12); z-index: 1050; min-width: 160px; }
    .custom-dropdown-premium .dropdown-item { border-radius: 8px; padding: 8px 14px; font-size: 0.85rem; font-weight: 600; color: var(--text-slate); }
    .custom-dropdown-premium .dropdown-item:hover { background-color: var(--soft-blue); color: var(--primary-blue); }
    .custom-dropdown-premium .dropdown-item.active { background-color: var(--primary-blue); color: white; }

    .product-card-modern { background: white; transition: 0.3s ease; border-radius: 16px !important; border: 1px solid rgba(0,0,0,0.05); }
    .product-card-modern:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .image-box { position: relative; width: 100%; padding-top: 100%; background: #f8fafc; overflow: hidden; border-radius: 16px 16px 0 0; }
    .image-box img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
    .badge-type { position: absolute; top: 8px; right: 8px; background: rgba(255,255,255,0.95); color: var(--primary-blue); padding: 4px 10px; border-radius: 50px; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; z-index: 5; }

    .product-name { color: var(--slate-dark); font-weight: 700; font-size: 0.85rem; line-height: 1.3; height: 2.6em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .product-price { color: var(--primary-blue); font-weight: 800; font-size: 1rem; }
    .btn-primary-soft { background-color: var(--soft-blue); color: var(--primary-blue); border: none; font-weight: 800; font-size: 0.7rem; transition: 0.3s; }

    @media (max-width: 768px) {
        .container { padding-top: 1rem !important; }
        .product-card-modern { border-radius: 12px !important; }
        .product-name { font-size: 0.75rem; }
        .product-price { font-size: 0.85rem; }
        .btn-sm-mobile { font-size: 0.65rem; padding: 0.3rem !important; }
    }
</style>

<script>
    function submitSort(value) {
        document.getElementById('sort-value').value = value;
        document.getElementById('form-sorting').submit();
    }
</script>
@endsection