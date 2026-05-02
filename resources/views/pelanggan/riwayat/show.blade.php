@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan #' . $pesanan->kode_pesanan)

@section('content')
<div class="container py-4 py-md-5">
    {{-- Header & Tombol Kembali --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 mb-md-4 gap-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm header-icon-box me-3">
                <i class="bi bi-receipt fs-5 fs-md-4"></i>
            </div>
            <div>
                <h4 class="fw-bold m-0 text-uppercase fs-5 fs-md-4" style="letter-spacing: 1px;">Detail Pesanan</h4>
                <p class="text-muted small m-0" style="font-size: 0.75rem;">Invoice ID: <span class="text-primary fw-bold">#{{ $pesanan->kode_pesanan }}</span></p>
            </div>
        </div>
        <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold align-self-start align-self-md-auto">
            <i class="bi bi-arrow-left me-1"></i> KEMBALI
        </a>
    </div>

    <div class="row g-3 g-md-4 flex-column-reverse flex-lg-row">
        {{-- SISI KIRI: Daftar Item --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4">
                <div class="card-header bg-white py-3 border-0 border-bottom">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted" style="letter-spacing: 1px;">Item yang Dipesan</h6>
                </div>
                
                {{-- TAMPILAN DESKTOP: TABLE (Disembunyikan di Mobile) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 small fw-bold text-muted border-0">PRODUK</th>
                                <th class="py-3 small fw-bold text-muted border-0 text-center">HARGA</th>
                                <th class="py-3 small fw-bold text-muted border-0 text-center">JUMLAH</th>
                                <th class="pe-4 py-3 small fw-bold text-muted border-0 text-end">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->detailPesanan as $detail)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-3 bg-light overflow-hidden shadow-sm" style="width: 60px; height: 60px;">
                                            @if($detail->produk->gambar)
                                                <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small" style="font-size: 0.6rem;">No Img</div>
                                            @endif
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-0 text-dark small">{{ $detail->produk->nama_produk }}</h6>
                                            <small class="text-muted">Freshly Baked</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center small">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center small">{{ $detail->jumlah }}x</td>
                                <td class="pe-4 text-end fw-bold text-dark">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="3" class="ps-4 py-3 text-end text-muted small">TOTAL PEMBAYARAN</th>
                                <th class="pe-4 py-3 text-end text-primary h5 fw-bold mb-0">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- TAMPILAN MOBILE: LIST (Hanya Muncul di Mobile) --}}
                <div class="d-md-none">
                    @foreach($pesanan->detailPesanan as $detail)
                    <div class="p-3 border-bottom border-light">
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-3 bg-light overflow-hidden shadow-sm flex-shrink-0" style="width: 50px; height: 50px;">
                                @if($detail->produk->gambar)
                                    <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted" style="font-size: 0.5rem;">No Img</div>
                                @endif
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.8rem;">{{ $detail->produk->nama_produk }}</h6>
                                <div class="text-muted" style="font-size: 0.7rem;">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-2">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1" style="font-size: 0.65rem;">
                                {{ $detail->jumlah }} Pcs
                            </span>
                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Bayar</span>
                        <span class="text-primary fw-bold fs-6">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="p-3 rounded-4 bg-white shadow-sm border-start border-primary border-4">
                <h6 class="fw-bold small mb-1"><i class="bi bi-info-circle me-1 text-primary"></i> Informasi Tambahan</h6>
                <p class="text-muted m-0" style="font-size: 0.75rem;">Roti akan dipacking dengan aman menggunakan box khusus. Pastikan simpan di suhu ruangan agar tetap empuk.</p>
            </div>
        </div>

        {{-- SISI KANAN: Info Pengiriman & Status --}}
        <div class="col-lg-4">
            {{-- Card Status --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4">
                <div class="card-header bg-primary text-white py-2 py-md-3 border-0">
                    <h6 class="fw-bold m-0 text-uppercase small" style="letter-spacing: 1px;">Status Pesanan</h6>
                </div>
                <div class="card-body p-3 p-md-4 text-center">
                    <div class="mb-4">
                        <label class="text-muted small d-block mb-2 text-uppercase fw-bold" style="font-size: 0.7rem;">Kondisi Saat Ini</label>
                        @php 
                            $rawStatus = strtolower($pesanan->status);
                            
                            // Logika Tampilan Pelanggan
                            if ($rawStatus == 'selesai') {
                                $st = ['color' => 'success', 'label' => 'SELESAI'];
                                $msg = "Hore! Pesananmu telah dikonfirmasi dan roti siap dinikmati.";
                            } elseif ($rawStatus == 'dibatalkan') {
                                $st = ['color' => 'danger', 'label' => 'DIBATALKAN'];
                                $msg = "Maaf, pesanan dibatalkan oleh Admin. Silakan hubungi kami untuk info lebih lanjut.";
                            } elseif ($rawStatus == 'pending' && $pesanan->bukti_bayar) {
                                // Jika status pending tapi bukti sudah ada = Ditolak
                                $st = ['color' => 'danger', 'label' => 'KIRIM ULANG'];
                                $msg = "Bukti transfer ditolak oleh Admin. Silakan unggah ulang bukti yang valid.";
                            } elseif ($pesanan->bukti_bayar) {
                                // Status diproses/dikirim (ada bukti, belum selesai)
                                $st = ['color' => 'info', 'label' => 'MENUNGGU VERIFIKASI'];
                                $msg = "Bukti transfer telah diterima. Mohon tunggu konfirmasi dari Admin Bakery.";
                            } else {
                                // Status pending (belum bayar sama sekali)
                                $st = ['color' => 'warning', 'label' => 'MENUNGGU'];
                                $msg = "Silakan selesaikan pembayaran dan unggah bukti transfer agar pesanan diproses.";
                            }
                        @endphp
                        
                        <span class="badge rounded-pill bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25 w-100 d-flex align-items-center justify-content-center" style="font-size: 0.85rem; height: 40px; letter-spacing: 0.5px;">
                            {{ $st['label'] }}
                        </span>
                        
                        <p class="text-muted mt-3 mb-0" style="font-size: 0.75rem;">{{ $msg }}</p>
                    </div>

                    <div class="d-flex justify-content-between text-start border-top pt-3">
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.65rem;"><i class="bi bi-credit-card me-1"></i> Metode</small>
                            <span class="fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">{{ $pesanan->metode_bayar }}</span>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block" style="font-size: 0.65rem;"><i class="bi bi-calendar-event me-1"></i> Waktu</small>
                            <span class="fw-bold text-dark" style="font-size: 0.8rem;">{{ $pesanan->created_at->format('d/m/Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORM UPLOAD BUKTI (Selalu muncul selama belum selesai/dibatalkan) --}}
            @if($rawStatus != 'selesai' && $rawStatus != 'dibatalkan')
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4" style="border: 2px dashed #0d6efd !important;">
                    <div class="card-body p-3 p-md-4 text-center">
                        <h6 class="fw-bold text-dark mb-3 small text-uppercase"><i class="bi bi-cloud-arrow-up me-2 text-primary"></i>Konfirmasi Pembayaran</h6>
                        
                        @if($pesanan->bukti_bayar)
                            <div class="mb-3 text-center">
                                <img src="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" class="img-fluid rounded-3 border shadow-sm mb-2" style="max-height: 120px; object-fit: cover;">
                                
                                {{-- Jika status pending (artinya Kirim Ulang), beri warning merah. Jika tidak, warna hijau --}}
                                @if($rawStatus == 'pending')
                                    <div class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 w-100" style="font-size: 0.7rem;">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i> Bukti Ditolak, Kirim Ulang!
                                    </div>
                                @else
                                    <div class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 w-100" style="font-size: 0.7rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Bukti Berhasil Diunggah
                                    </div>
                                @endif
                            </div>
                        @endif

                        <form action="{{ route('pelanggan.pesanan.upload-bukti', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" name="bukti_bayar" class="form-control form-control-sm border-0 bg-light py-2" required accept="image/*">
                                <div class="form-text mt-1 text-muted" style="font-size: 0.6rem;">Format: JPG/PNG (Maks. 2MB)</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill shadow-sm btn-sm py-2" style="font-size: 0.75rem;">
                                @if($rawStatus == 'pending' && $pesanan->bukti_bayar)
                                    UNGGAH ULANG BUKTI TRANSFER
                                @elseif($pesanan->bukti_bayar)
                                    GANTI BUKTI TRANSFER
                                @else
                                    UNGGAH BUKTI TRANSFER
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($pesanan->bukti_bayar)
                {{-- Jika sudah selesai tapi ada bukti bayarnya, tampilkan saja sbg history --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4">
                    <div class="card-header bg-white py-2 py-md-3 border-0 border-bottom text-center">
                        <h6 class="fw-bold m-0 text-uppercase small text-muted" style="letter-spacing: 1px;">Bukti Pembayaran</h6>
                    </div>
                    <div class="card-body p-3 text-center bg-light">
                        <img src="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" class="img-fluid rounded-3 border shadow-sm" style="max-height: 150px; object-fit: cover;">
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-2 py-md-3 border-0 border-bottom">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted" style="letter-spacing: 1px;">Tujuan Pengiriman</h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex mb-3">
                        <i class="bi bi-geo-alt-fill text-primary fs-5 me-2 me-md-3 mt-1"></i>
                        <div>
                            <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">Alamat Lengkap</small>
                            <p class="fw-medium mb-0 text-dark" style="font-size: 0.8rem; line-height: 1.5;">{{ $pesanan->alamat_pengiriman }}</p>
                        </div>
                    </div>
                    
                    <hr class="opacity-10 my-3">
                    
                    <div class="p-2 p-md-3 rounded-3 bg-light text-center">
                        <p class="text-muted mb-1" style="font-size: 0.65rem;">Butuh bantuan tentang pesanan ini?</p>
                        @php
                            // Ambil nomor WA toko dari setting atau gunakan default (Pastikan format 62)
                            $waToko = '6281234567890'; 
                            $textWa = urlencode("Halo Admin Bakery Bu Ani, saya ingin bertanya tentang pesanan saya dengan nomor Invoice #" . $pesanan->kode_pesanan);
                        @endphp
                        <a href="https://wa.me/{{ $waToko }}?text={{ $textWa }}" target="_blank" class="text-success fw-bold text-decoration-none" style="font-size: 0.75rem;">
                            <i class="bi bi-whatsapp me-1"></i> Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .header-icon-box { width: 45px; height: 45px; }
    .table thead th { font-size: 0.7rem; letter-spacing: 1px; }
    .badge { font-weight: 800; letter-spacing: 0.5px; }
    .fw-medium { word-break: break-word; }
    .form-control-sm:focus { box-shadow: none; border: 1px solid #4A90E2; }

    @media (max-width: 768px) {
        .container { padding-top: 1rem !important; }
        .header-icon-box { width: 35px; height: 35px; }
        
        /* Flex Order: Ubah susunan agar Form Pembayaran & Status ada di Atas pada tampilan Mobile */
        .flex-column-reverse { flex-direction: column-reverse; }
        
        /* Pengecilan jarak antar elemen di HP */
        .g-3 { --bs-gutter-y: 0.8rem; --bs-gutter-x: 0.8rem; }
        .mb-4 { margin-bottom: 1rem !important; }
        .p-4 { padding: 1rem !important; }
        .py-5 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
    }
</style>
@endsection