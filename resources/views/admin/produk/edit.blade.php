@extends('layouts.admin')

@section('title', 'Edit Produk - Toko Roti Ibu Ani')

@section('content')
<div class="container-fluid px-0 px-md-3 py-3 py-md-4">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-3 mb-md-4">
        <a href="{{ route('admin.produk.index') }}" class="btn btn-white border shadow-sm rounded-circle me-2 me-md-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; padding: 0;">
            <i class="bi bi-arrow-left text-dark"></i>
        </a>
        <div style="width: 5px; height: 25px; background-color: #8B4513; border-radius: 10px;" class="me-2 me-md-3"></div>
        <h5 class="fw-bold m-0 text-dark text-uppercase fs-6 fs-md-4" style="letter-spacing: 1px;">Edit Produk</h5>
    </div>

    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        {{-- flex-column-reverse di HP agar Gambar muncul lebih dulu dari Form --}}
        <div class="row g-3 g-md-4 flex-column-reverse flex-lg-row">
            
            {{-- Kolom Kiri: Detail Produk (Bawah di Mobile, Kiri di Desktop) --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 mb-lg-0">
                    <div class="card-header py-2 py-md-3 border-0 text-white" style="background-color: #8B4513;">
                        <h6 class="fw-bold m-0 small text-uppercase">
                            <i class="bi bi-pencil-square me-2"></i>Form Edit: {{ $produk->nama_produk }}
                        </h6>
                    </div>
                    
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row g-3 g-md-4">
                            {{-- Input Kategori --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-uppercase text-muted label-mobile">Kategori Roti</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-success"></i></span>
                                    <select name="kategori_id" class="form-select bg-light border-0 py-2 form-control-mobile @error('kategori_id') is-invalid @enderror" required>
                                        @foreach($kategoris as $k)
                                            <option value="{{ $k->id }}" {{ (old('kategori_id', $produk->kategori_id) == $k->id) ? 'selected' : '' }}>
                                                {{ $k->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('kategori_id') <div class="text-danger extra-small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Input Nama Roti --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-uppercase text-muted label-mobile">Nama Roti</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-pencil text-primary"></i></span>
                                    <input type="text" name="nama_produk" class="form-control bg-light border-0 py-2 form-control-mobile @error('nama_produk') is-invalid @enderror" 
                                           value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                                </div>
                                @error('nama_produk') <div class="text-danger extra-small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Input Harga --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-uppercase text-muted label-mobile">Harga Jual (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 fw-bold text-muted">Rp</span>
                                    <input type="number" name="harga" class="form-control bg-light border-0 py-2 form-control-mobile @error('harga') is-invalid @enderror" 
                                           value="{{ old('harga', $produk->harga) }}" required>
                                </div>
                                @error('harga') <div class="text-danger extra-small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Input Stok --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-uppercase text-muted label-mobile">Stok Saat Ini</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-box-seam text-warning"></i></span>
                                    <input type="number" name="stok" class="form-control bg-light border-0 py-2 form-control-mobile @error('stok') is-invalid @enderror" 
                                           value="{{ old('stok', $produk->stok) }}" required>
                                </div>
                                @error('stok') <div class="text-danger extra-small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Input Deskripsi --}}
                            <div class="col-12">
                                <label class="form-label fw-bold text-uppercase text-muted label-mobile">Deskripsi Produk</label>
                                <textarea name="deskripsi" class="form-control bg-light border-0 p-3 form-control-mobile @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                                @error('deskripsi') <div class="text-danger extra-small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi (Full Width di HP) --}}
                        <div class="d-flex flex-column flex-sm-row gap-2 mt-4 mt-md-5 pt-3 border-top">
                            <button type="submit" class="btn text-white px-4 py-2 py-md-3 rounded-pill fw-bold shadow-sm action-btn-mobile" style="background-color: #8B4513; border: none;">
                                <i class="bi bi-check2-circle me-2"></i> SIMPAN PERUBAHAN
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-light px-4 py-2 py-md-3 rounded-pill fw-bold text-muted border action-btn-mobile text-center">
                                BATAL
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Preview Gambar (Atas di Mobile, Kanan di Desktop) --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center overflow-hidden sticky-top" style="top: 80px;">
                    <div class="card-header py-2 py-md-3 bg-white border-bottom-0">
                        <h6 class="fw-bold m-0 text-uppercase text-muted" style="font-size: 0.75rem;"><i class="bi bi-image me-1"></i> Foto Produk</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        {{-- Frame Gambar Aspect Ratio 1:1 --}}
                        <div class="border-2 border-dashed rounded-4 bg-light text-center position-relative overflow-hidden d-flex align-items-center justify-content-center mx-auto" 
                             style="border: 2px dashed #dee2e6 !important; aspect-ratio: 1/1; max-width: 300px;">
                            
                            @if($produk->gambar)
                                <img id="imagePreview" src="{{ asset('images/produk/'.$produk->gambar) }}" alt="Preview" class="w-100 h-100 shadow-sm" style="object-fit: cover;">
                            @else
                                <img id="imagePreview" src="#" alt="Preview" class="w-100 h-100 d-none shadow-sm" style="object-fit: cover;">
                                <div id="placeholderWrap">
                                    <i class="bi bi-image display-4 text-muted"></i>
                                    <p class="small text-muted mt-2 mb-0">Belum ada foto</p>
                                </div>
                            @endif

                            <input type="file" name="gambar" id="imageInput" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="image/*">
                        </div>

                        <p class="small text-primary mt-3 mb-1 fw-bold" style="font-size: 0.7rem;">
                            <i class="bi bi-info-circle me-1"></i> Klik kotak untuk ganti foto baru
                        </p>
                        <div class="form-text text-muted" style="font-size: 0.65rem;">Maksimal 2MB (JPG, PNG, WEBP).</div>
                        @error('gambar') <div class="text-danger extra-small mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>

<script>
    // Script Live Preview Gambar
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const placeholderWrap = document.getElementById('placeholderWrap');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.classList.remove('d-none');
            if(placeholderWrap) placeholderWrap.classList.add('d-none');
        }
    }
</script>

<style>
    .btn-white { background-color: #fff; }
    .label-mobile { font-size: 0.75rem; letter-spacing: 1px; }
    .extra-small { font-size: 0.7rem; }
    
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.1);
        border: 1px solid #8B4513 !important;
    }
    .input-group:focus-within .input-group-text {
        background-color: #fff !important;
        border: 1px solid #8B4513 !important;
        border-right: none !important;
        color: #8B4513 !important;
    }
    .input-group:focus-within .form-control, .input-group:focus-within .form-select {
        border-left: none !important;
    }

    /* === RESPONSIVE TWEAKS === */
    @media (max-width: 768px) {
        .form-control-mobile { font-size: 0.85rem !important; padding-top: 0.4rem !important; padding-bottom: 0.4rem !important; }
        .action-btn-mobile { width: 100%; font-size: 0.85rem; }
        .g-3 { --bs-gutter-y: 0.8rem; --bs-gutter-x: 0.8rem; }
    }
</style>
@endsection