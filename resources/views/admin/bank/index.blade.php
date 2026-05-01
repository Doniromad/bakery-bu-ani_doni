@extends('layouts.admin')

@section('content')
<div class="container-fluid px-0 px-md-3 py-2 py-md-4">
    {{-- Header Halaman: Stack vertikal di HP --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div class="d-flex align-items-center">
            <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
            <h4 class="fw-bold m-0 text-dark fs-5 fs-md-4">Pengaturan Rekening Bank</h4>
        </div>
        <button class="btn text-white px-4 py-2 fw-bold shadow-sm w-100 w-md-auto" style="background-color: #8B4513; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#addBankModal">
            <i class="bi bi-plus-lg me-1"></i> TAMBAH BANK
        </button>
    </div>

    {{-- VIEW DESKTOP: TABLE (Disembunyikan di Mobile) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 border-0">
                <thead style="background-color: #fdf2e9;">
                    <tr>
                        <th class="ps-4 py-3 text-muted text-uppercase small border-0">Nama Bank</th>
                        <th class="py-3 text-muted text-uppercase small border-0">No. Rekening</th>
                        <th class="py-3 text-muted text-uppercase small border-0">Atas Nama</th>
                        <th class="py-3 text-muted text-uppercase small text-center border-0">Status</th>
                        <th class="pe-4 py-3 text-muted text-uppercase small text-center border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banks as $bank)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $bank->nama_bank }}</td>
                        <td class="fw-medium"><code>{{ $bank->no_rekening }}</code></td>
                        <td>{{ $bank->atas_nama }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill {{ $bank->is_active ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 text-{{ $bank->is_active ? 'success' : 'secondary' }} border border-{{ $bank->is_active ? 'success' : 'secondary' }} border-opacity-25 py-2 px-3" style="font-size: 0.7rem;">
                                {{ $bank->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="pe-4 text-center">
                            <form action="{{ route('admin.bank.destroy', $bank->id) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm border-0 rounded-circle p-2 hover-scale"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data bank.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- VIEW MOBILE: CARD LIST (Hanya Muncul di Mobile) --}}
    <div class="d-md-none">
        <div class="row g-3">
            @forelse($banks as $bank)
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                    <div class="position-absolute top-0 bottom-0 start-0 bg-{{ $bank->is_active ? 'success' : 'secondary' }}" style="width: 4px;"></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="fw-bold text-dark mb-0">{{ $bank->nama_bank }}</h6>
                                <small class="text-muted text-uppercase extra-small">Nama Bank</small>
                            </div>
                            <span class="badge rounded-pill bg-{{ $bank->is_active ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $bank->is_active ? 'success' : 'secondary' }} border border-{{ $bank->is_active ? 'success' : 'secondary' }} border-opacity-25 px-2 py-1" style="font-size: 0.6rem;">
                                {{ $bank->is_active ? 'AKTIF' : 'OFF' }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <div class="fw-bold text-primary" style="letter-spacing: 1px; font-size: 1rem;">{{ $bank->no_rekening }}</div>
                            <small class="text-muted text-uppercase extra-small">Nomor Rekening</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-end pt-2 border-top border-light">
                            <div>
                                <div class="fw-medium text-dark" style="font-size: 0.85rem;">{{ $bank->atas_nama }}</div>
                                <small class="text-muted text-uppercase extra-small">Atas Nama Pemilik</small>
                            </div>
                            <form action="{{ route('admin.bank.destroy', $bank->id) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-light border text-danger rounded-3 px-3 py-2 shadow-sm">
                                    <i class="bi bi-trash me-1"></i> HAPUS
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center text-muted bg-white rounded-4 shadow-sm border-0">
                <i class="bi bi-bank fs-1 d-block mb-2 opacity-25"></i>
                <p class="small mb-0">Belum ada rekening terdaftar.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL TAMBAH BANK (Dioptimalkan untuk HP) --}}
<div class="modal fade" id="addBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down px-3">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold text-dark"><i class="bi bi-bank2 me-2"></i>Tambah Rekening</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bank.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Bank</label>
                        <input type="text" name="nama_bank" class="form-control border-0 bg-light py-2 px-3" placeholder="Contoh: BCA, Mandiri, BRI" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nomor Rekening</label>
                        <input type="text" name="no_rekening" class="form-control border-0 bg-light py-2 px-3" placeholder="Masukkan nomor tanpa spasi" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted text-uppercase">Atas Nama Pemilik</label>
                        <input type="text" name="atas_nama" class="form-control border-0 bg-light py-2 px-3" placeholder="Masukkan nama sesuai di buku tabungan" required style="border-radius: 10px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 justify-content-center px-4">
                    <button type="submit" class="btn text-white w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: #8B4513; letter-spacing: 1px;">
                        SIMPAN REKENING
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .extra-small { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px; }
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.1); background-color: #dc3545; color: white !important; }
    
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #8B4513 !important;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.1);
    }

    @media (max-width: 768px) {
        .main-content { padding: 70px 10px 20px 10px !important; }
        .modal-fullscreen-sm-down .modal-content { border-radius: 15px; }
    }
</style>
@endsection