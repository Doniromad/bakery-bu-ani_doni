@extends('layouts.admin')

@section('title', 'Edit Produk - ' . $produk->nama_produk)

@section('content')
<div class="d-flex align-items-center mb-4">
    <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
    <h4 class="fw-bold m-0 text-dark">Edit Produk: <span class="text-muted small">#{{ $produk->id }}</span></h4>
</div>

<div class="row">
    {{-- SISI KIRI: Form Editttttttt--}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <form action="{{ route('admin.produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')

                    <div class="row">
                        {{-- Kategori --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Kategori Roti</label>
                            <select name="kategori_id" class="form-select border-0 bg-light @error('kategori_id') is-invalid @enderror" style="border-radius: 10px; padding: 12px;">
                                <option value="" disabled>-- Pilih Kategori --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id', $produk->kategori_id) == $k->id ? 'selected' : '' }}>
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
                                   value="{{ old('nama_produk', $produk->nama_produk) }}" style="border-radius: 10px; padding: 12px;">
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi Produk</label>
                        <textarea name="deskripsi" class="form-control border-0 bg-light" rows="4" 
                                  style="border-radius: 10px; padding: 12px;">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>

                    <div class="row">
                        {{-- Harga --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Harga Jual (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-dark text-white" style="border-radius: 10px 0 0 10px;">Rp</span>
                                <input type="number" name="harga" class="form-control border-0 bg-light @error('harga') is-invalid @enderror" 
                                       value="{{ old('harga', $produk->harga) }}" style="border-radius: 0 10px 10px 0; padding: 12px;">
                            </div>
                            @error('harga')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Stok --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control border-0 bg-light" value="{{ old('stok', $produk->stok) }}" 
                                   style="border-radius: 10px; padding: 12px;">
                        </div>
                    </div>

                    {{-- Ganti Gambar --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Ganti Gambar Produk</label>
                        <input type="file" name="gambar" id="imageInputEdit" class="form-control border-0 bg-light" accept="image/*" style="border-radius: 10px; padding: 12px;">
                        <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle me-1"></i> Kosongkan jika tidak ingin mengganti gambar produk.</small>
                    </div>

                    <div class="d-flex gap-2 border-top pt-4">
                        <button type="submit" class="btn text-white px-5 py-2 shadow-sm fw-bold" style="background-color: #8B4513; border-radius: 10px;">
                            <i class="bi bi-arrow-repeat me-2"></i> PERBARUI PRODUK
                        </button>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-light px-4 py-2 fw-bold" style="border-radius: 10px;">BATAL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SISI KANAN: Preview --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 text-center" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold m-0 text-muted small text-uppercase">Pratinjau Gambar</h6>
            </div>
            <div class="card-body p-4">
                {{-- Box Gambar --}}
                <div class="rounded-4 overflow-hidden shadow-sm mb-3" style="height: 250px; background-color: #f8f9fa;">
                    @if($produk->gambar)
                        <img id="imagePreviewEdit" src="{{ asset('images/produk/' . $produk->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                    @else
                        <img id="imagePreviewEdit" src="#" class="w-100 h-100 d-none" style="object-fit: cover;">
                        <div id="noImageText" class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                </div>
                <span class="badge bg-dark rounded-pill px-3 py-2 opacity-75" style="font-size: 0.7rem;">
                    <i class="bi bi-camera me-1"></i> GAMBAR SAAT INI
                </span>
            </div>
        </div>
    </div>
</div>

<script>
    // Script Live Preview
    const imageInputEdit = document.getElementById('imageInputEdit');
    const imagePreviewEdit = document.getElementById('imagePreviewEdit');
    const noImageText = document.getElementById('noImageText');

    imageInputEdit.onchange = evt => {
        const [file] = imageInputEdit.files;
        if (file) {
            imagePreviewEdit.src = URL.createObjectURL(file);
            imagePreviewEdit.classList.remove('d-none');
            if(noImageText) noImageText.classList.add('d-none');
            
            // Ubah label badge jadi "Gambar Baru"
            document.querySelector('.badge').innerHTML = '<i class="bi bi-stars me-1"></i> GAMBAR BARU';
            document.querySelector('.badge').classList.replace('bg-dark', 'bg-success');
        }
    }
</script>

<style>
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.15);
        border: 1px solid #8B4513 !important;
    }
</style>
@endsection