@extends($layout)

@section('content')
<div class="container py-5">
    <div class="row {{ $user->role === 'admin' ? '' : 'justify-content-center' }}">
        <div class="col-md-8">
            
            {{-- Header Profil --}}
            <div class="d-flex align-items-center mb-4 {{ $user->role === 'admin' ? '' : 'justify-content-center flex-column' }}">
                {{-- Avatar Lingkaran Inisial --}}
                <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center mb-3 mb-md-0 {{ $user->role === 'admin' ? 'me-3' : '' }}" 
                     style="width: 70px; height: 70px; background: {{ $user->role === 'admin' ? '#8B4513' : 'linear-gradient(135deg, #4A90E2 0%, #357ABD 100%)' }}; color: white; font-size: 1.5rem; font-weight: bold; border: 4px solid white;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                
                <div class="{{ $user->role === 'admin' ? '' : 'text-center' }}">
                    <h4 class="fw-bold m-0 text-dark">Pengaturan Profil</h4>
                    <p class="text-muted small m-0">Kelola informasi data diri dan keamanan akun Anda</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                {{-- Aksen Garis Atas --}}
                <div style="height: 5px; background: {{ $user->role === 'admin' ? '#8B4513' : '#4A90E2' }};"></div>
                
                <div class="card-body p-4 p-md-5">
                    {{-- Alert Status --}}
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 12px;">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            {{-- Nama Lengkap --}}
                            <div class="col-12">
                                <label class="form-label-custom fw-bold small text-uppercase" style="letter-spacing: 1px; color: #64748b;">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px;"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control border-start-0 py-2 @error('name') is-invalid @enderror" 
                                           style="border-radius: 0 12px 12px 0; background-color: #f8fafc;"
                                           value="{{ old('name', $user->name) }}" required>
                                </div>
                                @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Alamat Email --}}
                            <div class="col-12">
                                <label class="form-label-custom fw-bold small text-uppercase" style="letter-spacing: 1px; color: #64748b;">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px;"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 py-2 @error('email') is-invalid @enderror" 
                                           style="border-radius: 0 12px 12px 0; background-color: #f8fafc;"
                                           value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Nomor Telepon --}}
                            <div class="col-12">
                                <label class="form-label-custom fw-bold small text-uppercase" style="letter-spacing: 1px; color: #64748b;">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px;"><i class="bi bi-telephone"></i></span>
                                    <input type="number" name="no_telp" class="form-control border-start-0 py-2 @error('no_telp') is-invalid @enderror" 
                                           style="border-radius: 0 12px 12px 0; background-color: #f8fafc;"
                                           value="{{ old('no_telp', $user->no_telp) }}" placeholder="Contoh: 08123456789">
                                </div>
                                @error('no_telp') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Keamanan Akun --}}
                            <div class="col-12 mt-5 mb-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="fw-bold m-0 text-dark"><i class="bi bi-shield-lock me-2"></i>Keamanan Akun</h6>
                                    <hr class="flex-grow-1 ms-3 opacity-10">
                                </div>
                                <div class="alert alert-info py-2 border-0 mt-2" style="font-size: 0.75rem; background-color: #f0f7ff; color: #357ABD;">
                                    <i class="bi bi-info-circle-fill me-1"></i> Biarkan kosong jika tidak ingin mengganti kata sandi.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom fw-bold small text-uppercase" style="letter-spacing: 1px; color: #64748b;">Kata Sandi Baru</label>
                                <input type="password" name="password" class="form-control py-2 @error('password') is-invalid @enderror" 
                                       style="border-radius: 12px; background-color: #f8fafc;">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom fw-bold small text-uppercase" style="letter-spacing: 1px; color: #64748b;">Konfirmasi Sandi</label>
                                <input type="password" name="password_confirmation" class="form-control py-2" 
                                       style="border-radius: 12px; background-color: #f8fafc;">
                            </div>
                        </div>

                        <div class="mt-5 {{ $user->role === 'admin' ? '' : 'text-center' }}">
                            <button type="submit" class="btn px-5 py-3 fw-bold text-uppercase rounded-pill shadow-blue btn-save"
                                    style="background: {{ $user->role === 'admin' ? '#8B4513' : 'linear-gradient(135deg, #4A90E2 0%, #357ABD 100%)' }}; 
                                           color: white; font-size: 0.8rem; border: none; letter-spacing: 1px;">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Badge Role --}}
            <div class="mt-4 text-center">
                <span class="badge rounded-pill px-3 py-2" 
                      style="background: {{ $user->role === 'admin' ? '#fdf2e9' : '#f0f7ff' }}; 
                             color: {{ $user->role === 'admin' ? '#8B4513' : '#4A90E2' }}; 
                             font-size: 0.7rem; letter-spacing: 1px; border: 1px solid {{ $user->role === 'admin' ? '#8b451320' : '#4a90e220' }};">
                    <i class="bi bi-patch-check-fill me-1"></i> AKUN TERVERIFIKASI SEBAGAI {{ strtoupper($user->role) }}
                </span>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: white !important;
        border-color: {{ $user->role === 'admin' ? '#8B4513' : '#4A90E2' }} !important;
        box-shadow: 0 0 0 4px {{ $user->role === 'admin' ? '#8b451315' : '#4a90e215' }} !important;
    }
    
    .btn-save {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px {{ $user->role === 'admin' ? 'rgba(139, 69, 19, 0.2)' : 'rgba(74, 144, 226, 0.3)' }} !important;
    }

    .shadow-blue {
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
    }
</style>
@endsection