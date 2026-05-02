@extends('layouts.admin')

{{-- Ubah title agar saat diprint terbaca bersih --}}
@section('title', 'Pesanan #' . $pesanan->kode_pesanan)

@section('content')
<div class="container-fluid px-0 px-md-3 py-2 py-md-4 print-container">
    
    {{-- ========================================================
         HEADER KHUSUS PRINT (INVOICE STYLE) 
         Hanya muncul saat CTRL+P / Tekan tombol cetak
    ======================================================== --}}
    <div class="d-none d-print-block mb-4">
        <div class="row align-items-center mb-4 border-bottom pb-3">
            <div class="col-6">
                <h3 class="fw-bold m-0" style="color: #000; letter-spacing: 1px;">BAKERY BU ANI</h3>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">Jl. Bakery No. 12, Kota Roti</p>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">Telp: +62 812-3456-7890</p>
            </div>
            <div class="col-6 text-end">
                <h2 class="fw-bold text-uppercase m-0" style="color: #555; letter-spacing: 2px;">Invoice</h2>
                <p class="fw-bold mb-0 mt-1">#{{ $pesanan->kode_pesanan }}</p>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">Tanggal: {{ $pesanan->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <h6 class="fw-bold text-uppercase small text-muted mb-1">Tagihan Kepada:</h6>
                <div class="fw-bold fs-6">{{ $pesanan->user->name }}</div>
                <div style="font-size: 0.85rem; max-width: 250px;">
                    {{ $pesanan->alamat_pengiriman }}
                </div>
                @if($pesanan->user->no_telp)
                    <div style="font-size: 0.85rem;">Telp: {{ $pesanan->user->no_telp }}</div>
                @endif
            </div>
            <div class="col-6 text-end">
                <h6 class="fw-bold text-uppercase small text-muted mb-1">Metode Pembayaran:</h6>
                <div class="fw-bold fs-6 text-uppercase">{{ $pesanan->metode_bayar }}</div>
                <div style="font-size: 0.85rem;" class="mt-2">Status: <strong>{{ strtoupper($pesanan->status) }}</strong></div>
            </div>
        </div>
    </div>
    {{-- ======================================================== --}}


    {{-- Header Web Asli & Tombol Aksi (Sembunyi saat print) --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3 print-hide">
        <div class="d-flex align-items-center">
            <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-2 me-md-3"></div>
            <h5 class="fw-bold m-0 text-dark">Invoice: <code class="text-primary" style="font-size: 0.9rem;">#{{ $pesanan->kode_pesanan }}</code></h5>
        </div>
        
        <div class="d-flex gap-2 w-100 w-sm-auto justify-content-start justify-content-sm-end">
            {{-- TOMBOL CETAK RESI --}}
            <button onclick="window.print()" class="btn text-white btn-sm rounded-pill px-3 fw-bold d-flex align-items-center shadow-sm btn-hover-scale" style="background-color: #8B4513; border: none;">
                <i class="bi bi-printer me-2"></i> CETAK RESI
            </button>
            
            {{-- TOMBOL KEMBALI ASLI --}}
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold d-flex align-items-center">
                <i class="bi bi-arrow-left me-1"></i> KEMBALI
            </a>
        </div>
    </div>

    {{-- Layout Utama: Sisi Kiri (Tabel) dan Kanan (Status) --}}
    <div class="row g-3 g-md-4 flex-column-reverse flex-lg-row print-row">
        
        {{-- SISI KIRI: Daftar Barang & Info Transaksi --}}
        <div class="col-lg-8 print-col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4 print-card">
                <div class="card-header bg-white py-3 border-0 border-bottom print-hide">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted"><i class="bi bi-box-seam me-2"></i>Item Pesanan</h6>
                </div>
                
                {{-- VIEW DESKTOP/PRINT: TABLE --}}
                <div class="table-responsive d-none d-md-block print-show-table">
                    <table class="table align-middle mb-0 print-table">
                        <thead class="bg-light text-center print-thead">
                            <tr>
                                <th class="ps-3 ps-print-1 py-3 small fw-bold text-muted border-0 text-start print-th">PRODUK</th>
                                <th class="py-3 small fw-bold text-muted border-0 print-th">HARGA</th>
                                <th class="py-3 small fw-bold text-muted border-0 print-th">JUMLAH</th>
                                <th class="pe-3 pe-print-1 py-3 small fw-bold text-muted border-0 text-end print-th">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody class="print-tbody">
                            @foreach($pesanan->detailPesanan as $detail)
                            <tr>
                                <td class="ps-3 ps-print-1 py-3 print-td">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-3 bg-light overflow-hidden shadow-sm flex-shrink-0 print-hide" style="width: 50px; height: 50px;">
                                            @if($detail->produk->gambar)
                                                <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">No Img</div>
                                            @endif
                                        </div>
                                        <div class="ms-3 ms-print-0">
                                            <h6 class="fw-bold mb-0 text-dark small print-text-dark">{{ $detail->produk->nama_produk }}</h6>
                                            <small class="text-muted print-hide">ID: {{ $detail->produk->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center small text-muted print-td print-text-dark">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center small fw-bold print-td print-text-dark">{{ $detail->jumlah }}</td>
                                <td class="pe-3 pe-print-1 text-end fw-bold text-dark print-td">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background-color: #fdf2e9;" class="print-tfoot">
                            <tr>
                                <th colspan="3" class="ps-4 py-3 text-end text-muted small print-text-dark pt-print-3">
                                    <span class="print-hide">TOTAL PENDAPATAN</span>
                                    <span class="d-none d-print-inline fw-bold text-uppercase" style="letter-spacing: 1px;">TOTAL</span>
                                </th>
                                <th class="pe-3 pe-print-1 py-3 text-end h5 fw-bold mb-0 print-total pt-print-3" style="color: #8B4513;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- VIEW MOBILE WEB: LIST VIEW (Sembunyi saat cetak) --}}
                <div class="d-md-none print-hide">
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

            {{-- Pesan Terima Kasih Invoice (Hanya Muncul Saat Print) --}}
            <div class="d-none d-print-block text-center mt-5 pt-3 border-top">
                <p class="fw-bold mb-1" style="color: #000; font-size: 0.9rem;">TERIMA KASIH ATAS PESANAN ANDA!</p>
                <p class="text-muted" style="font-size: 0.8rem;">Roti kami selalu dibuat fresh dengan bahan pilihan terbaik.</p>
            </div>

            {{-- Info Transaksi Web Responsif (Disembunyikan saat print) --}}
            <div class="p-3 p-md-4 rounded-4 bg-white shadow-sm d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 print-hide">
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

        {{-- SISI KANAN: Kontrol & Profil (Di Atas saat Mobile, Sembunyi Full saat Print) --}}
        <div class="col-lg-4 print-hide">
            
            {{-- Card Info Pelanggan --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4">
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
                                <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn btn-sm text-white ms-2 rounded-pill px-2 py-0 shadow-sm" style="background-color: #25D366; font-size: 0.65rem; border: none;">
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

            {{-- CARD UPDATE STATUS --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4">
                <div class="card-header text-white py-2 py-md-3 border-0" style="background-color: #8B4513;">
                    <h6 class="fw-bold m-0 text-uppercase small"><i class="bi bi-gear-fill me-2"></i>Status Pesanan</h6>
                </div>
                <div class="card-body p-3 p-md-4 text-center">
                    
                    <div class="mb-3">
                        <label class="text-muted extra-small d-block mb-2 text-uppercase fw-bold">Status Saat Ini</label>
                        @php 
                            $statusMap = ['pending'=>'Menunggu / Belum Bayar','diproses'=>'Bukti Bayar Diunggah','dikirim'=>'Dikirim','selesai'=>'Pesanan Selesai','dibatalkan'=>'Dibatalkan'];
                            $badges = ['pending'=>'warning','diproses'=>'info','dikirim'=>'primary','selesai'=>'success','dibatalkan'=>'danger'];
                            $currentStatus = strtolower($pesanan->status);
                        @endphp
                        <span class="badge rounded-pill px-3 py-2 bg-{{ $badges[$currentStatus] ?? 'secondary' }} bg-opacity-10 text-{{ $badges[$currentStatus] ?? 'secondary' }} border border-{{ $badges[$currentStatus] ?? 'secondary' }} border-opacity-25 w-100" style="font-size: 0.85rem;">
                            <i class="bi bi-circle-fill me-1 small"></i> {{ $statusMap[$currentStatus] ?? ucfirst($pesanan->status) }}
                        </span>
                    </div>

                    {{-- LOGIKA TOMBOL KONFIRMASI DINAMIS (TANPA COD) --}}
                    @if($currentStatus == 'selesai')
                        <div class="alert alert-light border shadow-sm rounded-4 mb-0 py-3 mt-3">
                            <i class="bi bi-check-circle-fill text-success mb-2 fs-3 d-block"></i>
                            <p class="mb-0 small fw-bold text-dark">Pesanan ini telah dikunci (Selesai).</p>
                        </div>
                    @elseif($currentStatus == 'dibatalkan')
                        <p class="small text-muted mb-3 mt-3" style="font-size: 0.75rem;">Pesanan dibatalkan. Anda dapat memulihkannya jika terjadi kesalahan.</p>
                        <div class="d-flex flex-column gap-2">
                            <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST" onsubmit="return confirm('Pulihkan pesanan ini ke status Menunggu?')">
                                @csrf
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="btn btn-warning w-100 py-2 fw-bold rounded-pill shadow-sm btn-hover-scale" style="color: #6b3410; font-size: 0.85rem; background-color: #ffc107; border: none;">
                                    PULIHKAN (MENUNGGU)
                                </button>
                            </form>
                            <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST" onsubmit="return confirm('Tandai pesanan ini selesai?')">
                                @csrf
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="btn text-white w-100 py-2 fw-bold rounded-pill shadow-sm btn-hover-scale mt-1" style="background-color: #8B4513; font-size: 0.85rem; border: none;">
                                    TANDAI SELESAI
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-2 mt-3">
                            {{-- Karena hanya transfer, langsung periksa bukti_bayar --}}
                            @if($pesanan->bukti_bayar)
                                <p class="small text-muted mb-2" style="font-size: 0.75rem;">Periksa validitas <strong>Bukti Transfer</strong>. Jika tidak sesuai, tolak agar pelanggan mengunggah ulang.</p>
                                <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" class="btn text-white w-100 py-2 fw-bold rounded-pill shadow-sm btn-hover-scale" style="background-color: #8B4513; font-size: 0.85rem; border: none;">
                                        BUKTI VALID (SELESAI)
                                    </button>
                                </form>
                                <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST" onsubmit="return confirm('Tolak bukti transfer ini? Pesanan akan dikembalikan ke status Menunggu.')">
                                    @csrf
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit" class="btn btn-warning w-100 py-2 fw-bold rounded-pill shadow-sm btn-hover-scale" style="color: #6b3410; font-size: 0.85rem; background-color: #ffc107; border: none;">
                                        TOLAK BUKTI (REVISI)
                                    </button>
                                </form>
                                <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MEMBATALKAN pesanan ini secara permanen?')">
                                    @csrf
                                    <input type="hidden" name="status" value="dibatalkan">
                                    <button type="submit" class="btn btn-light text-muted w-100 py-2 fw-bold rounded-pill btn-hover-scale btn-batal-hover mt-1" style="font-size: 0.85rem; border: 1px solid #dee2e6;">
                                        BATALKAN PERMANEN
                                    </button>
                                </form>
                            @else
                                <p class="small text-muted mb-2" style="font-size: 0.75rem;">Menunggu pelanggan mengunggah bukti transfer.</p>
                                <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini karena tidak kunjung dibayar?')">
                                    @csrf
                                    <input type="hidden" name="status" value="dibatalkan">
                                    <button type="submit" class="btn btn-light text-muted w-100 py-2 fw-bold rounded-pill btn-hover-scale btn-batal-hover" style="font-size: 0.85rem; border: 1px solid #dee2e6;">
                                        BATALKAN PESANAN
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- CARD BUKTI PEMBAYARAN --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 mb-md-4 print-hide">
                <div class="card-header bg-white py-2 py-md-3 border-0 border-bottom">
                    <h6 class="fw-bold m-0 text-uppercase small text-muted"><i class="bi bi-receipt me-2"></i>Bukti Transfer</h6>
                </div>
                <div class="card-body p-3 p-md-4 text-center">
                    @if($pesanan->bukti_bayar)
                        <a href="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" target="_blank">
                            <img src="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" class="img-fluid rounded-3 border shadow-sm" style="max-height: 200px; width: 100%; object-fit: contain;">
                        </a>
                        <p class="mt-2 mb-0 small text-muted italic" style="font-size: 0.65rem;">Ketuk gambar untuk memperbesar</p>
                    @else
                        <div class="py-3">
                            <i class="bi bi-clock-history display-6 text-warning opacity-75"></i>
                            <p class="text-muted extra-small mt-2 mb-0 px-2 fw-bold">Menunggu Pelanggan</p>
                            <p class="text-muted extra-small mt-1 mb-0 px-2">Pelanggan belum mengunggah bukti bayar.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .extra-small { font-size: 0.65rem; }
    .bg-light { background-color: #f8f9fa !important; }

    /* Button Hover Effects */
    .btn-hover-scale { transition: all 0.2s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); }
    form button[type="submit"].text-white:hover { background-color: #6b3410 !important; box-shadow: 0 4px 10px rgba(139, 69, 19, 0.3) !important; }
    .btn-batal-hover:hover { background-color: #e9ecef !important; color: #dc3545 !important; border-color: #dc3545 !important; }

    @media (max-width: 768px) {
        .small-mobile { font-size: 0.85rem !important; }
        .main-content { padding: 70px 8px 20px 8px !important; }
        .flex-column-reverse { flex-direction: column-reverse !important; }
        .card-body { padding: 1rem !important; }
    }

    /* =========================================
       CSS KHUSUS UNTUK FITUR CETAK RESI
       ========================================= */
    @media print {
        /* MENGHILANGKAN HEADER & FOOTER BAWAAN BROWSER (URL, Tanggal, dll) */
        @page { 
            margin: 1.5cm; 
            size: auto;
        }
        
        body { background-color: white !important; font-family: Arial, sans-serif !important; -webkit-print-color-adjust: exact; }
        
        /* Sembunyikan elemen web murni */
        .sidebar, .navbar, .mobile-navbar, footer, .print-hide { display: none !important; }
        
        /* Normalisasi Grid */
        .print-row { flex-direction: row !important; }
        .print-col-12 { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
        .main-content, .main-wrapper { margin: 0 !important; width: 100% !important; padding: 0 !important; }
        
        /* Format Container/Card */
        .print-container { padding: 0 !important; }
        .print-card { box-shadow: none !important; border: none !important; margin: 0 !important; }
        
        /* Format Table Print (Clean Invoice Look) */
        .print-show-table { display: block !important; }
        .print-table { width: 100% !important; border-collapse: collapse !important; border: none !important; }
        
        /* Garis Bawah Header */
        .print-thead { background-color: transparent !important; }
        .print-thead th { border: none !important; border-bottom: 2px solid #000 !important; padding: 10px 0 !important; font-size: 0.85rem !important; color: #000 !important; }
        
        /* Isi Tabel */
        .print-tbody td { border: none !important; border-bottom: 1px solid #eee !important; padding: 12px 0 !important; }
        .ms-print-0 { margin-left: 0 !important; }
        .ps-print-1 { padding-left: 0 !important; }
        .pe-print-1 { padding-right: 0 !important; }
        
        /* Teks Hitam Pekat di Kertas */
        .print-text-dark { color: #000 !important; font-size: 0.9rem !important; }
        
        /* Format Footer Total */
        .print-tfoot { background-color: transparent !important; }
        .print-tfoot th { border: none !important; border-top: 2px solid #000 !important; }
        .pt-print-3 { padding-top: 15px !important; }
        .print-total { color: #000 !important; font-size: 1.2rem !important; }
    }
</style>
@endsection