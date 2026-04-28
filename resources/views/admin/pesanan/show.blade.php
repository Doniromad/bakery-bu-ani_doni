@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $pesanan->kode_pesanan)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
        <h4 class="fw-bold m-0 text-dark">Invoice: <code class="text-primary">#{{ $pesanan->kode_pesanan }}</code></h4>
    </div>
    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill fw-bold">
        <i class="bi bi-arrow-left me-1"></i> KEMBALI
    </a>
</div>

<div class="row g-4">
    {{-- SISI KIRI: Daftar Barang --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold m-0 text-uppercase small text-muted"><i class="bi bi-box-seam me-2"></i>Item Pesanan</h6>
            </div>
            <div class="table-responsive">
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
                                    <div class="rounded-3 bg-light overflow-hidden shadow-sm" style="width: 50px; height: 50px;">
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
        </div>

        <div class="p-4 rounded-4 bg-white shadow-sm d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="bg-light rounded-circle p-3 me-3 text-primary">
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Tanggal Transaksi</small>
                    <span class="fw-bold text-dark">{{ $pesanan->created_at->format('d F Y, H:i') }} WIB</span>
                </div>
            </div>
            <div class="text-end">
                <small class="text-muted d-block">Metode Pembayaran</small>
                <span class="badge bg-dark px-3 py-2 rounded-pill text-uppercase">{{ $pesanan->metode_bayar }}</span>
            </div>
        </div>
    </div>

    {{-- SISI KANAN: Kontrol & Profil --}}
    <div class="col-lg-4">
        {{-- Card Update Status --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header text-white py-3 border-0" style="background-color: #8B4513;">
                <h6 class="fw-bold m-0 text-uppercase small"><i class="bi bi-gear-fill me-2"></i>Update Status</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST">
                    @csrf
                    <div class="mb-4 text-center">
                        <label class="text-muted small d-block mb-2 text-uppercase fw-bold">Status Saat Ini</label>
                        @php 
                            // Mapping Nama Status ke Bahasa Indonesia
                            $statusMap = [
                                'pending' => 'Menunggu',
                                'diproses' => 'Bukti Bayar',
                                'dikirim' => 'Dikirim',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan'
                            ];
                            $badges = [
                                'pending' => 'warning',
                                'diproses' => 'info',
                                'dikirim' => 'primary',
                                'selesai' => 'success',
                                'dibatalkan' => 'danger'
                            ];
                            $currentStatus = strtolower($pesanan->status);
                        @endphp
                        <span class="badge rounded-pill px-4 py-2 bg-{{ $badges[$currentStatus] ?? 'secondary' }} bg-opacity-10 text-{{ $badges[$currentStatus] ?? 'secondary' }} border border-{{ $badges[$currentStatus] ?? 'secondary' }} border-opacity-25 fs-6">
                            {{ $statusMap[$currentStatus] ?? ucfirst($pesanan->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <select name="status" class="form-select border-0 bg-light" style="border-radius: 10px; padding: 12px;">
                            <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Bukti Bayar</option>
                            <option value="dikirim" {{ $pesanan->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button class="btn btn-dark w-100 py-2 fw-bold rounded-pill shadow-sm" style="background-color: #8B4513; border: none;">
                        SIMPAN PERUBAHAN
                    </button>
                </form>
            </div>
        </div>

        {{-- CARD BUKTI PEMBAYARAN --}}
        @if(str_contains(strtolower($pesanan->metode_bayar), 'transfer'))
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-3 border-0 border-bottom">
                <h6 class="fw-bold m-0 text-uppercase small text-muted"><i class="bi bi-image me-2"></i>Bukti Transfer</h6>
            </div>
            <div class="card-body p-4 text-center">
                @if($pesanan->bukti_bayar)
                    <a href="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" target="_blank">
                        <img src="{{ asset('images/bukti_bayar/' . $pesanan->bukti_bayar) }}" class="img-fluid rounded-3 border shadow-sm" style="max-height: 250px;">
                    </a>
                    <p class="mt-2 mb-0 small text-muted italic">Klik gambar untuk melihat ukuran penuh</p>
                @else
                    <div class="py-3">
                        <i class="bi bi-camera-fill display-6 text-light"></i>
                        <p class="text-muted small mt-2 mb-0">Pelanggan belum mengunggah bukti pembayaran.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Card Info Pelanggan --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-0 border-bottom">
                <h6 class="fw-bold m-0 text-uppercase small text-muted"><i class="bi bi-person-badge me-2"></i>Profil Pelanggan</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Nama Lengkap:</small>
                    <div class="fw-bold text-dark">{{ $pesanan->user->name }}</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Email:</small>
                    <div class="fw-medium">{{ $pesanan->user->email }}</div>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block mb-1">Alamat Tujuan:</small>
                    <p class="small fw-medium mb-0" style="line-height: 1.6;">{{ $pesanan->alamat_pengiriman }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.1);
        border: 1px solid #8B4513 !important;
    }
    .bg-light { background-color: #f8f9fa !important; }
</style>
@endsection