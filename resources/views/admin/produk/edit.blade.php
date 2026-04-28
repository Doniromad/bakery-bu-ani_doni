@extends('layouts.admin')

@section('title', 'Edit Produk - Toko Roti Ibu Ani')

@section('content')
<div class="container py-4">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.produk.index') }}" class="btn btn-white border shadow-sm rounded-circle me-3">
            <i class="bi bi-arrow-left text-dark"></i>
        </a>
        <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
        <h4 class="fw-bold m-0 text-dark text-uppercase" style="letter-spacing: 1px;">Edit Produk</h4>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Header Card dengan aksen cokelat --}}
                <div class="card-header py-3 border-0 text-white" style="background-color: #8B4513;">
                    <h6 class="fw-bold m-0 small text-uppercase">
                        <i class="bi bi-pencil-square me-2"></i>Form Edit: {{ $produk->nama_produk }}
                    </h6>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            {{-- Input Nama Roti --}}
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase text-muted" style="letter-spacing: 1px;">Nama Roti</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-pencil text-primary"></i></span>
                                    <input type="text" name="nama_produk" class="form-control bg-light border-0 py-2" value="{{ $produk->nama_produk }}" required>
                                </div>
                            </div>

                            {{-- Input Harga --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted" style="letter-spacing: 1px;">Harga Jual (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 fw-bold text-muted">Rp</span>
                                    <input type="number" name="harga" class="form-control bg-light border-0 py-2" value="{{ $produk->harga }}" required>
                                </div>
                            </div>

                            {{-- Input Stok --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted" style="letter-spacing: 1px;">Stok Saat Ini</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-box-seam text-warning"></i></span>
                                    <input type="number" name="stok" class="form-control bg-light border-0 py-2" value="{{ $produk->stok }}" required>
                                </div>
                            </div>

                            {{-- Input Gambar --}}
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase text-muted" style="letter-spacing: 1px;">Gambar Produk</label>
                                <div class="row align-items-center">
                                    @if($produk->gambar)
                                        <div class="col-auto">
                                            <img src="{{ asset('images/produk/'.$produk->gambar) }}" class="rounded-4 border shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <div class="col">
                                        <div class="p-3 border-2 border-dashed rounded-4 bg-light text-center position-relative" style="border: 2px dashed #dee2e6 !important;">
                                            <i class="bi bi-cloud-arrow-up fs-2 text-muted"></i>
                                            <p class="small text-muted mb-0">Klik untuk ganti foto baru</p>
                                            <input type="file" name="gambar" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="image/*">
                                        </div>
                                        <small class="text-muted mt-2 d-block">*Biarkan kosong jika tidak ingin mengganti gambar.</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Input Deskripsi --}}
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase text-muted" style="letter-spacing: 1px;">Deskripsi Produk</label>
                                <textarea name="deskripsi" class="form-control bg-light border-0 p-3" rows="4">{{ $produk->deskripsi }}</textarea>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex gap-2 mt-5">
                            <button type="submit" class="btn btn-dark px-5 py-3 rounded-pill fw-bold shadow-sm" style="background-color: #8B4513; border: none; font-size: 0.85rem;">
                                <i class="bi bi-check2-circle me-2"></i> SIMPAN PERUBAHAN
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-light px-4 py-3 rounded-pill fw-bold text-muted border" style="font-size: 0.85rem;">
                                BATAL
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-white { background-color: #fff; }
    .form-control:focus, .input-group-text:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.1);
        border: 1px solid #8B4513 !important;
    }
    .input-group:focus-within .input-group-text {
        background-color: #fff !important;
        border: 1px solid #8B4513 !important;
        border-right: none !important;
    }
    .input-group:focus-within .form-control {
        border-left: none !important;
    }
</style>
@endsection