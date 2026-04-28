@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan #' . $pesanan->kode_pesanan)

@section('content')
<div class="container py-5">
    {{-- Header & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 45px; height: 45px;">
                <i class="bi bi-receipt fs-5"></i>
            </div>
            <div class="ms-3">
                <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">Detail Pesanan</h4>
                <p class="text-muted small m-0">Invoice ID: <span class="text-primary fw-bold">#{{ $pesanan->kode_pesanan }}</span></p>
            </div>
        </div>
        <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
            <i class="bi bi-arrow-left me-1"></i> KEMBALI
        </a>
    </div>

    <div class="row g-4">
        {{-- SISI KIRI: Daftar Item --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted" style="letter-spacing: 1px;">Item yang Dipesan</h6>
                </div>
                <div class="table-responsive">
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
            </div>
            
            <div class="p-3 rounded-4 bg-white shadow-sm border-start border-primary border-4">
                <h6 class="fw-bold small mb-1"><i class="bi bi-info-circle me-1 text-primary"></i> Informasi Tambahan</h6>
                <p class="text-muted m-0 small">Roti akan dipacking dengan aman menggunakan box khusus. Pastikan simpan di suhu ruangan agar tetap empuk.</p>
            </div>
        </div>

        {{-- SISI KANAN: Info Pengiriman & Status --}}
        <div class="col-lg-4">
            {{-- Card Status --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-primary text-white py-3 border-0">
                    <h6 class="fw-bold m-0 text-uppercase small" style="letter-spacing: 1px;">Status & Pembayaran</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="text-muted small d-block mb-2 text-uppercase fw-bold">Status Pesanan</label>
                        @php 
                            // Mapping Status yang sama dengan Admin
                            $statusMap = [
                                'pending' => 'Menunggu',
                                'diproses' => 'Bukti Bayar',
                                'dikirim' => 'Dalam Pengiriman',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan'
                            ];
                            $badges = [
                                'pending' => ['color' => 'warning', 'icon' => 'hourglass-split'],
                                'diproses' => ['color' => 'info', 'icon' => 'camera-fill'],
                                'dikirim' => ['color' => 'primary', 'icon' => 'truck'],
                                'selesai' => ['color' => 'success', 'icon' => 'check-circle-fill'],
                                'dibatalkan' => ['color' => 'danger', 'icon' => 'x-circle-fill']
                            ];
                            $currentStatus = strtolower($pesanan->status);
                            $st = $badges[$currentStatus] ?? ['color' => 'secondary', 'icon' => 'question'];
                        @endphp
                        <span class="badge rounded-pill px-3 py-2 bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} border border-{{ $st['color'] }} border-opacity-25 w-100 fs-6">
                            <i class="bi bi-{{ $st['icon'] }} me-1"></i> {{ $statusMap[$currentStatus] ?? strtoupper($pesanan->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block"><i class="bi bi-credit-card me-1"></i> Metode Pembayaran</small>
                        <span class="fw-bold text-dark text-uppercase">{{ $pesanan->metode_bayar }}</span>
                    </div>
                    
                    <div class="mb-0">
                        <small class="text-muted d-block"><i class="bi bi-calendar-event me-1"></i> Waktu Transaksi</small>
                        <span class="fw-bold text-dark">{{ $pesanan->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            {{-- FORM UPLOAD BUKTI (Logika diperkuat) --}}
            @if(str_contains(strtolower($pesanan->metode_bayar), 'transfer'))
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="border: 2px dashed #0d6efd !important;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3 small text-uppercase"><i class="bi bi-cloud-arrow-up me-2 text-primary"></i>Konfirmasi Pembayaran</h6>
                    
                    @if($pesanan->bukti_bayar)
                        <div class="mb-3 text-center">
                            <img src="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" class="img-fluid rounded-3 border shadow-sm mb-2" style="max-height: 150px;">
                            <div class="alert alert-success py-2 px-3 border-0 small rounded-3 mb-0">
                                <i class="bi bi-check-circle-fill me-1"></i> Bukti sudah terkirim
                            </div>
                        </div>
                    @endif

                    {{-- Form muncul jika status belum SELESAI atau DIBATALKAN --}}
                    @if(!in_array(strtolower($pesanan->status), ['selesai', 'dibatalkan']))
                        <form action="{{ route('pelanggan.pesanan.upload-bukti', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" name="bukti_bayar" class="form-control form-control-sm border-0 bg-light" required accept="image/*">
                                <div class="form-text" style="font-size: 0.65rem;">Format: JPG, PNG, JPEG (Maks. 2MB)</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill shadow-sm btn-sm py-2">
                                {{ $pesanan->bukti_bayar ? 'GANTI BUKTI' : 'UNGGAH BUKTI BAYAR' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 border-bottom">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted" style="letter-spacing: 1px;">Tujuan Pengiriman</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex mb-3">
                        <i class="bi bi-geo-alt-fill text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">Alamat Lengkap</small>
                            <p class="fw-medium mb-0 small" style="line-height: 1.6;">{{ $pesanan->alamat_pengiriman }}</p>
                        </div>
                    </div>
                    
                    <hr class="opacity-10">
                    
                    <div class="p-3 rounded-3 bg-light text-center">
                        <p class="small text-muted mb-0">Butuh bantuan terkait pesanan ini?</p>
                        <a href="https://wa.me/628123456789" class="text-primary fw-bold text-decoration-none small">Hubungi Admin Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th { font-size: 0.7rem; letter-spacing: 1px; }
    .badge { font-weight: 800; letter-spacing: 0.5px; }
    .fw-medium { word-break: break-word; }
    .form-control-sm:focus { box-shadow: none; border: 1px solid #4A90E2; }
</style>
@endsection