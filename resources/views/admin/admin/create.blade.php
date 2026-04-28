@extends('layouts.admin')

@section('title', 'Tambah Produk Baru - Toko Roti Ibu Ani')

@section('content')
<div class="d-flex align-items-center mb-4">
    <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
    <h4 class="fw-bold m-0 text-dark">Tambah Produk Baru</h4>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- Kategori --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Kategori Roti</label>
                            <select name="kategori_id" class="form-select border-0 bg-light @error('kategori_id') is-invalid @enderror" style="border-radius: 10px; padding: 12px;">
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Produk --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control border-0 bg-light @error('nama_produk') is-invalid @enderror" 
                                   value="{{ old('nama_produk') }}" placeholder="Contoh: Roti Tawar Spesial" style="border-radius: 10px; padding: 12px;">
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi Produk</label>
                        <textarea name="deskripsi" class="form-control border-0 bg-light" rows="4" 
                                  placeholder="Ceritakan keunggulan roti ini..." style="border-radius: 10px; padding: 12px;">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="row">
                        {{-- Harga --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-dark text-white" style="border-radius: 10px 0 0 10px;">Rp</span>
                                <input type="number" name="harga" class="form-control border-0 bg-light @error('harga') is-invalid @enderror" 
                                       value="{{ old('harga') }}" placeholder="0" style="border-radius: 0 10px 10px 0; padding: 12px;">
                            </div>
                            @error('harga')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Stok --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control border-0 bg-light" value="{{ old('stok', 0) }}" 
                                   style="border-radius: 10px; padding: 12px;">
                        </div>
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Gambar Produk</label>
                        <input type="file" name="gambar" id="imageInput" class="form-control border-0 bg-light" accept="image/*" style="border-radius: 10px; padding: 12px;">
                        <small class="text-muted mt-2 d-block">Rekomendasi: Ukuran kotak (1:1), Maks 2MB.</small>
                    </div>

                    <div class="d-flex gap-2 border-top pt-4">
                        <button type="submit" class="btn text-white px-5 py-2 shadow-sm fw-bold" style="background-color: #8B4513; border-radius: 10px;">
                            <i class="bi bi-cloud-upload me-2"></i> PUBLIKASIKAN
                        </button>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-light px-4 py-2 fw-bold" style="border-radius: 10px;">BATAL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Kolom Preview Gambar --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 text-center" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold m-0 text-muted small text-uppercase">Preview Gambar</h6>
            </div>
            <div class="card-body p-4">
                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center overflow-hidden shadow-inner" style="min-height: 250px; border: 2px dashed #ddd;">
                    <img id="imagePreview" src="#" alt="Preview" class="w-100 h-100 d-none" style="object-fit: cover;">
                    <div id="placeholderText" class="text-muted small px-3">
                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                        Pilih file untuk melihat pratinjau
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script untuk Preview Gambar
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const placeholderText = document.getElementById('placeholderText');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.classList.remove('d-none');
            placeholderText.classList.add('d-none');
        }
    }
</script>

<style>
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.15);
        border: 1px solid #8B4513 !important;
    }
    .input-group-text {
        font-weight: bold;
    }
</style>
@endsection