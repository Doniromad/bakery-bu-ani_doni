@extends('layouts.pelanggan')

@section('title', 'Keranjang Belanja - Toko Roti Ibu Ani')

@section('content')
<div class="container py-4 py-md-5">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-3 mb-md-4">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm header-icon-box me-3">
            <i class="bi bi-cart3 fs-5 fs-md-4"></i>
        </div>
        <div>
            <h4 class="fw-bold m-0 text-uppercase fs-5 fs-md-4" style="letter-spacing: 1px;">Keranjang Belanja</h4>
            <p class="text-muted small m-0" style="font-size: 0.75rem;">Kelola pesanan roti kamu sebelum pembayaran.</p>
        </div>
    </div>

    @if($keranjangs->isEmpty())
        {{-- Tampilan Keranjang Kosong --}}
        <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
            <div class="card-body">
                <i class="bi bi-basket2 text-muted opacity-25 mb-3" style="font-size: 4rem;"></i>
                <h5 class="fw-bold mt-2 fs-6 fs-md-5">Wah, keranjangmu masih kosong!</h5>
                <p class="text-muted mb-4 small">Ayo jelajahi varian roti lezat kami dan mulai belanja.</p>
                <a href="{{ route('pelanggan.produk.index') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                    <i class="bi bi-arrow-left me-2"></i>Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <div class="row g-3 g-md-4 flex-column-reverse flex-lg-row">
            {{-- SISI KIRI: Daftar Produk --}}
            <div class="col-lg-8">
                
                {{-- TAMPILAN DESKTOP: TABLE (Disembunyikan di Mobile) --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Produk</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Harga</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Jumlah</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-end">Subtotal</th>
                                    <th class="pe-4 py-3 text-center text-uppercase small fw-bold text-muted">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keranjangs as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 bg-light overflow-hidden shadow-sm flex-shrink-0" style="width: 65px; height: 65px;">
                                                @if($item->produk->gambar)
                                                    <img src="{{ asset('images/produk/' . $item->produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                                @else
                                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">No Img</div>
                                                @endif
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">{{ $item->produk->nama_produk }}</h6>
                                                <span class="badge bg-soft-blue text-primary border-0 px-2 py-1" style="font-size: 0.65rem;">Roti Segar</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-medium text-center small">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center bg-light rounded-pill px-3 py-1 border border-light shadow-sm">
                                            <span class="fw-bold text-dark">{{ $item->jumlah }}</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-primary text-end">Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
                                    <td class="pe-4 text-center">
                                        <form action="{{ route('pelanggan.keranjang.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus roti ini dari keranjang?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm border-0 rounded-circle p-2 d-inline-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAMPILAN MOBILE: LIST (Hanya Muncul di Mobile) --}}
                <div class="d-md-none">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                        <div class="card-header bg-white py-3 border-0 border-bottom">
                            <h6 class="fw-bold m-0 text-uppercase small text-muted" style="letter-spacing: 1px;">Item di Keranjang</h6>
                        </div>
                        @foreach($keranjangs as $item)
                        <div class="p-3 border-bottom border-light position-relative">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-3 bg-light overflow-hidden shadow-sm flex-shrink-0" style="width: 60px; height: 60px;">
                                    @if($item->produk->gambar)
                                        <img src="{{ asset('images/produk/' . $item->produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted" style="font-size: 0.5rem;">No Img</div>
                                    @endif
                                </div>
                                <div class="ms-3 pe-4 flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.85rem; line-height: 1.3;">{{ $item->produk->nama_produk }}</h6>
                                    <div class="text-muted" style="font-size: 0.75rem;">Rp {{ number_format($item->produk->harga, 0, ',', '.') }} / pcs</div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="d-flex align-items-center bg-light rounded-pill px-3 py-1 border border-secondary border-opacity-10">
                                    <span class="text-muted me-2" style="font-size: 0.65rem;">Jml:</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $item->jumlah }}</span>
                                </div>
                                <div class="text-end">
                                    <div class="text-muted" style="font-size: 0.6rem; letter-spacing: 0.5px;">SUBTOTAL</div>
                                    <span class="fw-bold text-primary" style="font-size: 0.9rem;">Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            {{-- Tombol Hapus Absolute di Pojok Kanan Atas --}}
                            <form action="{{ route('pelanggan.keranjang.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus roti ini dari keranjang?')" class="position-absolute" style="top: 10px; right: 10px;">
                                @csrf @method('DELETE')
                                <button class="btn text-danger p-1 border-0 bg-transparent">
                                    <i class="bi bi-x-circle fs-5"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                {{-- Tombol Lanjut Belanja --}}
                <div class="mt-3 text-center text-md-start">
                    <a href="{{ route('pelanggan.produk.index') }}" class="text-primary text-decoration-none fw-bold" style="font-size: 0.8rem;">
                        <i class="bi bi-chevron-left me-1"></i> LANJUT PILIH ROTI LAIN
                    </a>
                </div>
            </div>

            {{-- SISI KANAN: Ringkasan Belanja --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-3 p-md-4">
                        <h6 class="fw-bold mb-3 mb-md-4 text-uppercase border-bottom pb-3" style="letter-spacing: 1px;">Ringkasan Belanja</h6>
                        
                        <div class="d-flex justify-content-between mb-2 text-muted" style="font-size: 0.85rem;">
                            <span>Total Item</span>
                            <span class="fw-bold text-dark">{{ $keranjangs->sum('jumlah') }} Pcs</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3 text-muted" style="font-size: 0.85rem;">
                            <span>Total Harga Produk</span>
                            <span class="fw-medium text-dark">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <hr class="my-3 opacity-10 border-secondary">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">TOTAL BAYAR</span>
                            <span class="fw-bold text-primary fs-5">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('pelanggan.checkout') }}" class="btn btn-primary py-2 py-md-3 fw-bold rounded-pill text-uppercase shadow-sm" style="letter-spacing: 1px; font-size: 0.85rem;">
                                Checkout Sekarang <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                        
                        <div class="mt-3 p-2 p-md-3 bg-light rounded-3 text-center">
                            <small class="text-muted" style="font-size: 0.65rem; line-height: 1.5;">
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
    /* Styling Dasar & Desktop */
    .bg-soft-blue { background-color: #F0F7FF; }
    .table thead th { letter-spacing: 0.5px; border-bottom: 2px solid #F0F7FF; font-size: 0.75rem; }
    .table tbody tr { transition: 0.2s; }
    .table tbody tr:hover { background-color: #f8fbff !important; }
    
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.1); background-color: #dc3545; color: white !important; }
    
    .header-icon-box { width: 45px; height: 45px; }

    /* === RESPONSIVE MOBILE === */
    @media (max-width: 768px) {
        .container { padding-top: 1rem !important; }
        .header-icon-box { width: 35px; height: 35px; }
        
        /* Flex Column Reverse: Pastikan tombol Checkout (Ringkasan) muncul DI ATAS daftar roti di HP */
        .flex-column-reverse { flex-direction: column-reverse; }
        
        /* Jarak antar elemen */
        .g-3 { --bs-gutter-y: 0.8rem; --bs-gutter-x: 0.8rem; }
    }
</style>
@endsection