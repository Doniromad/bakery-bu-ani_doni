@extends('layouts.pelanggan')

@section('title', 'Keranjang Belanja - Toko Roti Ibu Ani')

@section('content')
<div class="container py-5">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 50px; height: 50px;">
            <i class="bi bi-cart3 fs-4"></i>
        </div>
        <div class="ms-3">
            <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">Keranjang Belanja</h4>
            <p class="text-muted small m-0">Kelola pesanan roti kamu sebelum melakukan pembayaran.</p>
        </div>
    </div>

    @if($keranjangs->isEmpty())
        {{-- Tampilan Keranjang Kosong yang Cantik --}}
        <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
            <div class="card-body">
                <i class="bi bi-basket2 text-muted opacity-25" style="font-size: 5rem;"></i>
                <h5 class="fw-bold mt-4">Wah, keranjangmu masih kosong!</h5>
                <p class="text-muted mb-4">Ayo jelajahi varian roti lezat kami dan mulai belanja.</p>
                <a href="{{ route('home') }}#produk" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
                    <i class="bi bi-arrow-left me-2"></i>Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            {{-- Tabel Produk --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Produk</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Harga</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Jumlah</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Subtotal</th>
                                    <th class="pe-4 py-3 text-center text-uppercase small fw-bold text-muted">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keranjangs as $item)
                                <tr>
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            {{-- Foto Produk --}}
                                            <div class="rounded-3 bg-light overflow-hidden shadow-sm" style="width: 70px; height: 70px;">
                                                @if($item->produk->gambar)
                                                    <img src="{{ asset('images/produk/' . $item->produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                                @else
                                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">No Img</div>
                                                @endif
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-1 text-dark">{{ $item->produk->nama_produk }}</h6>
                                                <span class="badge bg-soft-blue text-primary border-0 small px-2 py-1">Roti Segar</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-medium">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center bg-light rounded-pill px-2 py-1" style="width: fit-content;">
                                            <span class="px-3 fw-bold">{{ $item->jumlah }}</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-primary">Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
                                    <td class="pe-4 text-center">
                                        <form action="{{ route('pelanggan.keranjang.destroy', $item) }}" method="POST" 
                                              onsubmit="return confirm('Hapus roti ini dari keranjang?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm border-0 rounded-circle p-2 shadow-sm">
                                                <i class="bi bi-trash3 fs-6"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Tombol Lanjut Belanja --}}
                <div class="mt-4">
                    <a href="{{ route('home') }}#produk" class="text-primary text-decoration-none fw-bold small">
                        <i class="bi bi-chevron-left me-1"></i> LANJUT PILIH ROTI LAIN
                    </a>
                </div>
            </div>

            {{-- Ringkasan Belanja --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                        
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Total Item</span>
                            <span class="fw-bold">{{ $keranjangs->sum('jumlah') }} Pcs</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3 text-muted small">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <hr class="my-4 opacity-10">

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold h5 mb-0 text-dark">Total Bayar</span>
                            <span class="fw-bold h5 mb-0 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('pelanggan.checkout') }}" class="btn btn-primary py-3 fw-bold rounded-3 text-uppercase shadow-sm" style="letter-spacing: 1px;">
                                Checkout Sekarang <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                        
                        <div class="mt-4 p-3 bg-light rounded-3">
                            <small class="text-muted d-block" style="font-size: 0.7rem; line-height: 1.5;">
                                <i class="bi bi-shield-check text-success me-1"></i> Pembayaran aman & produk dipastikan segar setiap harinya.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Tambahan style agar selaras dengan tema utama */
    .bg-soft-blue {
        background-color: #F0F7FF;
    }
    .table thead th {
        letter-spacing: 0.5px;
        border-bottom: 2px solid #F0F7FF;
    }
    .table tbody tr {
        transition: 0.3s;
    }
    .table tbody tr:hover {
        background-color: #fafbfc !important;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
@endsection