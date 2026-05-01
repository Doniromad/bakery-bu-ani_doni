@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $pesanan->kode_pesanan)

@section('content')
<div class="container-fluid px-0 px-md-3 py-2 py-md-4">
    {{-- Header & Tombol Kembali --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
        <div class="d-flex align-items-center">
            <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-2 me-md-3"></div>
            <h5 class="fw-bold m-0 text-dark">Invoice: <code class="text-primary" style="font-size: 0.9rem;">#{{ $pesanan->kode_pesanan }}</code></h5>
        </div>
        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
            <i class="bi bi-arrow-left me-1"></i> KEMBALI
        </a>
    </div>

    {{-- Layout Utama: Reverse di Mobile agar Status & Bukti ada di Atas --}}
    <div class="row g-3 g-md-4 flex-column-reverse flex-lg-row">
        
        {{-- SISI KIRI: Daftar Barang & Info Transaksi --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4">
                <div class="card-header bg-white py-3 border-0 border-bottom">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted"><i class="bi bi-box-seam me-2"></i>Item Pesanan</h6>
                </div>
                
                {{-- VIEW DESKTOP: TABLE --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light text-center">
                            <tr>
                                <th class="ps-4 py-3 small fw-bold text-muted border-0 text-start">PRODUK</th>
                                <th class="py-3 small fw-bold text-muted border-0">HARGA</th>
                                <th class="py-3 small fw-bold text-muted border-0">JUMLAH</th>
                                <th class="pe-4 py-3 small fw-bold text-muted border-0 text-end">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->detailPesanan as $detail)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-3 bg-light overflow-hidden shadow-sm flex-shrink-0" style="width: 50px; height: 50px;">
                                            @if($detail->produk->gambar)
                                                <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">No Img</div>
                                            @endif
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-0 text-dark small">{{ $detail->produk->nama_produk }}</h6>
                                            <small class="text-muted">ID: {{ $detail->produk->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center small text-muted">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center small fw-bold">{{ $detail->jumlah }}x</td>
                                <td class="pe-4 text-end fw-bold text-dark">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background-color: #fdf2e9;">
                            <tr>
                                <th colspan="3" class="ps-4 py-3 text-end text-muted small">TOTAL PENDAPATAN</th>
                                <th class="pe-4 py-3 text-end h5 fw-bold mb-0" style="color: #8B4513;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- VIEW MOBILE: LIST VIEW --}}
                <div class="d-md-none">
                    @foreach($pesanan->detailPesanan as $detail)
                    <div class="p-3 border-bottom border-light">
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-3 bg-light overflow-hidden border shadow-sm flex-shrink-0" style="width: 45px; height: 45px;">
                                @if($detail->produk->gambar)
                                    <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">Img</div>
                                @endif
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.8rem;">{{ $detail->produk->nama_produk }}</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }} x {{ $detail->jumlah }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-bold">TOTAL PENDAPATAN</span>
                        <span class="fw-bold fs-6" style="color: #8B4513;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Info Transaksi Responsif --}}
            <div class="p-3 p-md-4 rounded-4 bg-white shadow-sm d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <div class="d-flex align-items-center">
                    <div class="bg-light rounded-circle p-2 p-md-3 me-3 text-primary">
                        <i class="bi bi-calendar-check fs-5 fs-md-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Tanggal Transaksi</small>
                        <span class="fw-bold text-dark small-mobile">{{ $pesanan->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
                <div class="text-start text-sm-end">
                    <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">Metode Pembayaran</small>
                    <span class="badge bg-dark px-3 py-2 rounded-pill text-uppercase" style="font-size: 0.65rem;">{{ $pesanan->metode_bayar }}</span>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: Kontrol & Profil (Di Atas saat Mobile) --}}
        <div class="col-lg-4">
            {{-- Card Update Status --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4">
                <div class="card-header text-white py-2 py-md-3 border-0" style="background-color: #8B4513;">
                    <h6 class="fw-bold m-0 text-uppercase small"><i class="bi bi-gear-fill me-2"></i>Status Pesanan</h6>
                </div>
                <div class="card-body p-3 p-md-4 text-center">
                    <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="text-muted extra-small d-block mb-2 text-uppercase fw-bold">Status Saat Ini</label>
                            @php 
                                $statusMap = ['pending'=>'Menunggu','diproses'=>'Bukti Bayar','dikirim'=>'Dikirim','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'];
                                $badges = ['pending'=>'warning','diproses'=>'info','dikirim'=>'primary','selesai'=>'success','dibatalkan'=>'danger'];
                                $currentStatus = strtolower($pesanan->status);
                            @endphp
                            <span class="badge rounded-pill px-3 py-2 bg-{{ $badges[$currentStatus] ?? 'secondary' }} bg-opacity-10 text-{{ $badges[$currentStatus] ?? 'secondary' }} border border-{{ $badges[$currentStatus] ?? 'secondary' }} border-opacity-25 w-100 fs-6">
                                {{ $statusMap[$currentStatus] ?? ucfirst($pesanan->status) }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <select name="status" class="form-select border-0 bg-light py-2" style="border-radius: 10px; font-size: 0.9rem;">
                                <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Bukti Bayar</option>
                                <option value="dikirim" {{ $pesanan->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button class="btn btn-dark w-100 py-2 fw-bold rounded-pill shadow-sm" style="background-color: #8B4513; border: none; font-size: 0.85rem;">
                            SIMPAN PERUBAHAN
                        </button>
                    </form>
                </div>
            </div>

            {{-- CARD BUKTI PEMBAYARAN --}}
            @if(str_contains(strtolower($pesanan->metode_bayar), 'transfer'))
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4">
                <div class="card-header bg-white py-2 py-md-3 border-0 border-bottom">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted"><i class="bi bi-image me-2"></i>Bukti Transfer</h6>
                </div>
                <div class="card-body p-3 p-md-4 text-center">
                    @if($pesanan->bukti_bayar)
                        <a href="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" target="_blank">
                            <img src="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" class="img-fluid rounded-3 border shadow-sm" style="max-height: 200px; width: 100%; object-fit: contain;">
                        </a>
                        <p class="mt-2 mb-0 small text-muted italic" style="font-size: 0.65rem;">Ketuk gambar untuk memperbesar</p>
                    @else
                        <div class="py-3">
                            <i class="bi bi-camera-fill display-6 text-light opacity-50"></i>
                            <p class="text-muted extra-small mt-2 mb-0 px-2">Pelanggan belum mengunggah bukti bayar.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Card Info Pelanggan --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-2 py-md-3 border-0 border-bottom">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted"><i class="bi bi-person-badge me-2"></i>Profil Pelanggan</h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">Nama & Email:</small>
                        <div class="fw-bold text-dark small-mobile">{{ $pesanan->user->name }}</div>
                        <div class="text-muted extra-small text-truncate">{{ $pesanan->user->email }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">Nomor WhatsApp:</small>
                        <div class="fw-bold d-flex align-items-center">
                            <span class="small-mobile">{{ $pesanan->user->no_telp ?? 'Belum diatur' }}</span>
                            @if($pesanan->user->no_telp)
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $pesanan->user->no_telp);
                                    if (str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn btn-sm btn-success ms-2 rounded-pill px-2 py-0" style="font-size: 0.65rem;">
                                    <i class="bi bi-whatsapp"></i> CHAT
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">Alamat Lengkap:</small>
                        <p class="fw-medium mb-0" style="line-height: 1.5; font-size: 0.75rem;">{{ $pesanan->alamat_pengiriman }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .extra-small { font-size: 0.65rem; }
    .form-select:focus { box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.1); border: 1px solid #8B4513 !important; }
    .bg-light { background-color: #f8f9fa !important; }

    @media (max-width: 768px) {
        .small-mobile { font-size: 0.85rem !important; }
        .main-content { padding: 70px 8px 20px 8px !important; }
        
        /* Prioritaskan status di HP agar admin bisa langsung update */
        .flex-column-reverse { flex-direction: column-reverse !important; }
        
        /* Padding card yang lebih hemat ruang */
        .card-body { padding: 1rem !important; }
    }
</style>
@endsection