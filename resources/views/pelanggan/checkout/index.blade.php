@extends('layouts.pelanggan')

@section('title', 'Checkout - Toko Roti Ibu Ani')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <div style="width: 5px; height: 30px; background-color: var(--primary-blue); border-radius: 10px;" class="me-3"></div>
        <h4 class="fw-bold m-0 text-dark text-uppercase" style="letter-spacing: 1px;">Checkout Pesanan</h4>
    </div>

    <div class="row g-4">
        {{-- SISI KIRI: Ringkasan Pesanan --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold m-0 text-muted small text-uppercase"><i class="bi bi-cart-check me-2"></i>Ringkasan Belanja</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-muted">
                                    <th class="ps-4 border-0">PRODUK</th>
                                    <th class="text-end pe-4 border-0">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keranjangs as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark">{{ $item->produk->nama_produk }}</div>
                                        <small class="text-muted">{{ $item->jumlah }} pcs x Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                    </td>
                                    <td class="pe-4 text-end fw-bold text-dark">
                                        Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="background-color: #f0f7ff;">
                                <tr>
                                    <th class="ps-4 py-3 text-dark">TOTAL PEMBAYARAN</th>
                                    <th class="pe-4 py-3 text-end text-primary h5 fw-bold mb-0">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: Form Pengiriman & Pembayaran --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold m-0 text-muted small text-uppercase"><i class="bi bi-truck me-2"></i>Detail Pengiriman</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pelanggan.checkout.store') }}" method="POST">
                        @csrf
                        
                        {{-- Alamat --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Alamat Lengkap Pengiriman</label>
                            <textarea name="alamat_pengiriman" class="form-control border-0 bg-light p-3" rows="3" required 
                                      placeholder="Contoh: Jl. Slamet Riyadi No. 123, Solo" style="border-radius: 12px;">{{ auth()->user()->alamat }}</textarea>
                        </div>

                        {{-- Metode Bayar (Hidden input karena hanya ada 1 metode) --}}
                        <input type="hidden" name="metode_bayar" value="transfer">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Metode Pembayaran</label>
                            <div class="p-3 bg-light d-flex align-items-center justify-content-between" style="border-radius: 12px;">
                                <span class="fw-bold text-dark small">Transfer Bank (Verifikasi Manual)</span>
                                <i class="bi bi-patch-check-fill text-primary"></i>
                            </div>
                        </div>

                        {{-- INFO BANK (Selalu Tampil) --}}
                        <div class="p-3 rounded-4 mb-4" style="background-color: #fdf2e9; border: 1px dashed #8B4513;">
                            <h6 class="fw-bold small mb-3 text-uppercase" style="color: #8B4513; letter-spacing: 1px;">
                                <i class="bi bi-bank me-2"></i>Rekening Tujuan:
                            </h6>
                            
                            @forelse($banks as $bank)
                                <div class="mb-3 border-bottom border-warning border-opacity-25 pb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-white text-dark shadow-sm px-3 mb-1 border border-warning">{{ $bank->nama_bank }}</span>
                                        <span class="small fw-bold text-dark">{{ $bank->no_rekening }}</span>
                                    </div>
                                    <div class="small text-muted text-end">A/N: <strong class="text-dark">{{ $bank->atas_nama }}</strong></div>
                                </div>
                            @empty
                                <p class="small text-muted italic">Data bank belum tersedia.</p>
                            @endforelse

                            <div class="mt-2 text-center">
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    *Silahkan transfer sesuai total, lalu upload bukti di menu <strong>Riwayat Pesanan</strong> setelah membuat pesanan.
                                </small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm text-uppercase" 
                                style="letter-spacing: 1px; font-size: 0.85rem;">
                            Konfirmasi & Buat Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.15);
        border: 1px solid var(--primary-blue) !important;
    }
    .badge { font-weight: 700; }
</style>
@endsection