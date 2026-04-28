@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Header Halaman --}}
    <h4 class="fw-bold mb-4 text-dark" style="border-left: 5px solid #8B4513; padding-left: 15px;">
        <i class="bi bi-image me-2"></i>Pengaturan Hero Banner
    </h4>

    <div class="row">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    
                    {{-- Alert Success --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- 1. Preview Banner --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Preview Banner Saat Ini</label>
                            <div class="position-relative border rounded-4 overflow-hidden bg-light d-flex align-items-center justify-content-center shadow-inner" style="min-height: 250px; border-style: dashed !important; border-width: 2px !important;">
                                @if($banner && $banner->gambar)
                                    <img src="{{ asset('storage/banners/' . $banner->gambar) }}" class="img-fluid" style="max-height: 300px; width: 100%; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2">Aktif</span>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-cloud-arrow-up display-4 d-block mb-2 opacity-25"></i>
                                        <p class="mb-0">Belum ada banner yang diunggah</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            {{-- 2. Input Gambar --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Ganti Gambar Banner</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-camera"></i></span>
                                    <input type="file" name="gambar" class="form-control border-start-0 bg-light @error('gambar') is-invalid @enderror">
                                </div>
                                <div class="form-text text-muted small">
                                    <i class="bi bi-info-circle me-1"></i> Rekomendasi: 1200x400 pixel (Maks 2MB)
                                </div>
                                @error('gambar') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- 3. Input Judul --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Judul Banner <span class="text-muted fw-normal">(Opsional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-fonts"></i></span>
                                    <input type="text" name="judul" class="form-control border-start-0 bg-light" 
                                           value="{{ old('judul', $banner->judul ?? '') }}" placeholder="Contoh: Promo Roti Manis Baru">
                                </div>
                            </div>

                            {{-- 4. Input Deskripsi --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Deskripsi Singkat <span class="text-muted fw-normal">(Opsional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-chat-left-text"></i></span>
                                    <textarea name="deskripsi" class="form-control border-start-0 bg-light" rows="3" 
                                              placeholder="Jelaskan detail penawaran atau promo...">{{ old('deskripsi', $banner->deskripsi ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Button Simpan --}}
                        <div class="text-end border-top pt-4">
                            <button type="submit" class="btn px-5 py-2 fw-bold text-uppercase shadow-sm rounded-pill" 
                                    style="background-color: #8B4513; color: white; border: none;">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fokus Input ala Admin (Cokelat) */
    .form-control:focus {
        border-color: #8B4513;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.15);
        background-color: #fff;
    }
    
    .rounded-4 { border-radius: 1rem !important; }
    
    /* Hover Efek Tombol */
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        transition: 0.3s;
    }

    .shadow-inner {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
    }
</style>
@endsection