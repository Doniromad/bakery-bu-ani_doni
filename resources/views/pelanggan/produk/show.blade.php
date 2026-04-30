@extends('layouts.pelanggan')

@section('title', $produk->nama_produk . ' - Bakery Bu Ani')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center g-4 g-lg-5">
        
        {{-- SISI KIRI: Gambar Produk (Dibuat Lebih Kecil & Terkontrol) --}}
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
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
                    
                    {{-- Badge Kategori Melayang --}}
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-white text-primary rounded-pill px-3 py-2 shadow-sm fw-bold border-0" style="font-size: 0.65rem;">
                            {{ strtoupper($produk->kategori->nama ?? 'Varian Roti') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: Informasi & Form --}}
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 bg-transparent">
                <div class="card-body p-0">
                    {{-- Navigasi Balik yang Simpel --}}
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb small p-0 m-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
                            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Detail Produk</li>
                        </ol>
                    </nav>

                    <h2 class="fw-bold text-dark mb-1" style="font-family: 'Playfair Display', serif; font-size: 2rem;">
                        {{ $produk->nama_produk }}
                    </h2>
                    
                    <div class="h3 fw-bold text-primary mb-3">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>

                    <div class="mb-4">
                        <label class="text-uppercase small fw-bold text-muted d-block mb-1" style="letter-spacing: 1px;">Deskripsi</label>
                        <p class="text-muted" style="line-height: 1.6; font-size: 0.95rem;">
                            {{ $produk->deskripsi ?? 'Roti lezat yang dipanggang segar setiap hari menggunakan bahan premium untuk kualitas rasa terbaik bagi keluarga Anda.' }}
                        </p>
                    </div>

                    <hr class="border-light opacity-10 my-4">

                    @if($produk->stok > 0)
                        <form action="{{ route('pelanggan.keranjang.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            
                            <div class="row g-4 align-items-end">
                                {{-- Selector Jumlah --}}
                                <div class="col-auto">
                                    <label class="small fw-bold text-muted text-uppercase mb-2 d-block">Jumlah</label>
                                    <div class="d-flex align-items-center bg-white border rounded-pill p-1 shadow-sm" style="width: fit-content;">
                                        <button class="btn btn-link text-dark p-0 px-2 border-0" type="button" onclick="decrement()">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                        <input type="number" id="qty-input" name="jumlah" class="form-control border-0 bg-transparent text-center fw-bold p-0" 
                                               value="1" min="1" max="{{ $produk->stok }}" readonly style="width: 40px; font-size: 0.9rem;">
                                        <button class="btn btn-link text-dark p-0 px-2 border-0" type="button" onclick="increment()">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Stok Info --}}
                                <div class="col">
                                    <span class="small fw-bold text-success bg-success bg-opacity-10 px-3 py-1 rounded-pill">
                                        <i class="bi bi-box-seam me-1"></i> Stok: {{ $produk->stok }}
                                    </span>
                                </div>

                                {{-- Tombol Action --}}
                                <div class="col-12">
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-3 fw-bold shadow-sm flex-grow-1" style="letter-spacing: 0.5px; font-size: 0.85rem;">
                                            <i class="bi bi-cart-plus me-2"></i> TAMBAH KE KERANJANG
                                        </button>
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-3 fw-bold" style="font-size: 0.85rem;">
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
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 mt-2 fw-bold">Kembali</a>
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
    
    /* Hilangkan Spin Arrow pada Input Number */
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