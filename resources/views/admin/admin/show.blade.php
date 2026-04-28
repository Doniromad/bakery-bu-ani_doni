@extends('layouts.pelanggan')

@section('title', $produk->nama_produk . ' - Toko Roti Ibu Ani')

@section('content')
<div class="container py-5">
    {{-- Navigasi Kembali --}}
    <div class="mb-4">
        <a href="{{ route('home') }}#produk" class="text-decoration-none text-muted fw-bold small">
            <i class="bi bi-arrow-left me-1"></i> KEMBALI PILIH ROTI
        </a>
    </div>

    <div class="row g-5">
        {{-- SISI KIRI: Gambar Produk --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden p-2 bg-white">
                @if($produk->gambar)
                    <img src="{{ asset('images/produk/' . $produk->gambar) }}"
                         class="img-fluid rounded-4 w-100"
                         style="min-height: 400px; object-fit: cover;"
                         alt="{{ $produk->nama_produk }}">
                @else
                    <div class="bg-light rounded-4 d-flex align-items-center justify-content-center"
                         style="min-height: 400px; font-size: 5rem;">🍞</div>
                @endif
            </div>
        </div>

        {{-- SISI KANAN: Informasi & Form --}}
        <div class="col-lg-7">
            <div class="ps-lg-3">
                {{-- Badge Kategori --}}
                <span class="badge bg-soft-blue text-primary px-3 py-2 rounded-pill small fw-bold mb-3">
                    {{ $produk->kategori->nama ?? 'Varian Roti' }}
                </span>

                <h1 class="fw-bold mb-2 text-dark" style="font-family: 'Playfair Display', serif;">{{ $produk->nama_produk }}</h1>
                
                <h3 class="fw-bold text-primary mb-4">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </h3>

                <p class="text-muted mb-4" style="line-height: 1.8;">
                    {{ $produk->deskripsi ?? 'Roti segar yang dibuat dengan bahan pilihan berkualitas tinggi, tanpa pengawet, dan dipanggang setiap hari untuk menjamin kelembutan rasa di setiap gigitan.' }}
                </p>

                <div class="d-flex align-items-center mb-4">
                    @if($produk->stok > 0)
                        <div class="d-flex align-items-center text-success fw-bold small">
                            <i class="bi bi-check-circle-fill me-2"></i> Stok Tersedia: {{ $produk->stok }} Pcs
                        </div>
                    @else
                        <div class="d-flex align-items-center text-danger fw-bold small">
                            <i class="bi bi-x-circle-fill me-2"></i> Stok Sedang Habis
                        </div>
                    @endif
                </div>

                <hr class="my-4 opacity-10">

                @if($produk->stok > 0)
                    <form action="{{ route('pelanggan.keranjang.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        
                        <div class="row align-items-end g-3">
                            {{-- Input Jumlah --}}
                            <div class="col-auto">
                                <label class="form-label small fw-bold text-muted text-uppercase">Jumlah</label>
                                <div class="input-group shadow-sm rounded-pill overflow-hidden" style="width: 140px; border: 1px solid #eee;">
                                    <button class="btn btn-white border-0 px-3" type="button" onclick="changeQty(-1)">-</button>
                                    <input type="number" name="jumlah" id="qty-input" class="form-control border-0 text-center fw-bold bg-white" value="1" min="1" max="{{ $produk->stok }}" readonly>
                                    <button class="btn btn-white border-0 px-3" type="button" onclick="changeQty(1)">+</button>
                                </div>
                            </div>

                            {{-- Tombol Beli --}}
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm py-3 text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">
                                    <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <button class="btn btn-secondary btn-lg w-100 rounded-pill py-3 fw-bold" disabled>
                        MAAF, STOK HABIS
                    </button>
                @endif

                {{-- Fitur Singkat --}}
                <div class="row mt-5">
                    <div class="col-4 text-center">
                        <i class="bi bi-patch-check text-primary fs-3 d-block mb-2"></i>
                        <span class="small fw-bold">Bahan Premium</span>
                    </div>
                    <div class="col-4 text-center">
                        <i class="bi bi-truck text-primary fs-3 d-block mb-2"></i>
                        <span class="small fw-bold">Kirim Cepat</span>
                    </div>
                    <div class="col-4 text-center">
                        <i class="bi bi-sun text-primary fs-3 d-block mb-2"></i>
                        <span class="small fw-bold">Panggang Baru</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-blue { background-color: #F0F7FF; }
    
    /* Hilangkan panah input number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    #qty-input:focus {
        box-shadow: none;
    }
    
    .btn-white:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    function changeQty(amount) {
        const input = document.getElementById('qty-input');
        const max = parseInt(input.getAttribute('max'));
        let current = parseInt(input.value);
        
        let newValue = current + amount;
        
        if(newValue >= 1 && newValue <= max) {
            input.value = newValue;
        }
    }
</script>
@endsection