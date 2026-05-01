@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2 px-md-3 py-2 py-md-4">
    {{-- Header Halaman Responsif --}}
    <h5 class="fw-bold mb-3 mb-md-4 text-dark d-flex align-items-center" style="border-left: 5px solid #8B4513; padding-left: 15px;">
        <i class="bi bi-image me-2"></i> Pengaturan Hero Banner
    </h5>

    <div class="row">
        {{-- Menggunakan col-12 agar full-width di mobile --}}
        <div class="col-12 col-lg-10">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3 p-md-4">
                    
                    {{-- Alert Success --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                            <i class="bi bi-check-circle-fill me-1 me-md-2"></i> <span class="small">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- 1. Preview Banner --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted extra-small text-uppercase">Preview Banner Saat Ini</label>
                            {{-- Penyesuaian min-height agar proporsional di HP --}}
                            <div class="position-relative border rounded-4 overflow-hidden bg-light d-flex align-items-center justify-content-center shadow-inner banner-preview-box">
                                @if($banner && $banner->gambar)
                                    <img src="{{ asset('storage/banners/' . $banner->gambar) }}" class="img-fluid w-100" style="height: 100%; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 m-2 m-md-3">
                                        <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2 small">Aktif</span>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-4 py-md-5">
                                        <i class="bi bi-cloud-arrow-up display-4 d-block mb-2 opacity-25"></i>
                                        <p class="mb-0 small">Belum ada banner diunggah</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            {{-- 2. Input Gambar --}}
                            <div class="col-12 mb-3 mb-md-4">
                                <label class="form-label fw-bold small">Ganti Gambar Banner</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-camera"></i></span>
                                    <input type="file" name="gambar" class="form-control border-start-0 bg-light small @error('gambar') is-invalid @enderror">
                                </div>
                                <div class="form-text text-muted extra-small">
                                    <i class="bi bi-info-circle me-1"></i> Rekomendasi: 1200x400 px (Maks 2MB)
                                </div>
                                @error('gambar') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- 3. Input Judul --}}
                            <div class="col-12 mb-3 mb-md-4">
                                <label class="form-label fw-bold small">Judul Banner <span class="text-muted fw-normal small">(Opsional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-fonts"></i></span>
                                    <input type="text" name="judul" class="form-control border-start-0 bg-light small" 
                                           value="{{ old('judul', $banner->judul ?? '') }}" placeholder="Contoh: Promo Roti Manis Baru">
                                </div>
                            </div>

                            {{-- 4. Input Deskripsi --}}
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold small">Deskripsi Singkat <span class="text-muted fw-normal small">(Opsional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 align-items-start pt-2"><i class="bi bi-chat-left-text"></i></span>
                                    <textarea name="deskripsi" class="form-control border-start-0 bg-light small" rows="3" 
                                              placeholder="Jelaskan detail penawaran...">{{ old('deskripsi', $banner->deskripsi ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Button Simpan: Full-width di Mobile, Auto di Desktop --}}
                        <div class="text-md-end border-top pt-3 pt-md-4">
                            <button type="submit" class="btn w-100 w-md-auto px-md-5 py-2 fw-bold text-uppercase shadow-sm rounded-pill" 
                                    style="background-color: #8B4513; color: white; border: none; font-size: 0.85rem;">
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
    /* Styling Dasar & Desktop */
    .extra-small { font-size: 0.7rem; letter-spacing: 1px; }
    .banner-preview-box { min-height: 250px; border-style: dashed !important; border-width: 2px !important; }

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

    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05); }

    /* === RESPONSIVE MOBILE TWEAKS === */
    @media (max-width: 768px) {
        .banner-preview-box { min-height: 180px; }
        .main-content { padding: 70px 10px 20px 10px !important; }
        .btn-close { padding: 0.8rem; }
        .small { font-size: 0.8rem !important; }
        
        /* Tombol simpan melebar penuh di HP agar mudah ditekan */
        .w-md-auto { width: 100% !important; }
    }
</style>
@endsection