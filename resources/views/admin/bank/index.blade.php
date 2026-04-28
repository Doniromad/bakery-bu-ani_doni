@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <div style="width: 5px; height: 30px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
        <h4 class="fw-bold m-0 text-dark">Pengaturan Rekening Bank</h4>
    </div>
    <button class="btn text-white px-4 fw-bold shadow-sm" style="background-color: #8B4513; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#addBankModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Bank
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: #fdf2e9;">
                <tr>
                    <th class="ps-4 py-3 text-muted text-uppercase small">Nama Bank</th>
                    <th class="py-3 text-muted text-uppercase small">No. Rekening</th>
                    <th class="py-3 text-muted text-uppercase small">Atas Nama</th>
                    <th class="py-3 text-muted text-uppercase small text-center">Status</th>
                    <th class="pe-4 py-3 text-muted text-uppercase small text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banks as $bank)
                <tr>
                    <td class="ps-4 fw-bold text-dark">{{ $bank->nama_bank }}</td>
                    <td class="fw-medium">{{ $bank->no_rekening }}</td>
                    <td>{{ $bank->atas_nama }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill {{ $bank->is_active ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 text-{{ $bank->is_active ? 'success' : 'secondary' }} border border-{{ $bank->is_active ? 'success' : 'secondary' }} border-opacity-25">
                            {{ $bank->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="pe-4 text-center">
                        <form action="{{ route('admin.bank.destroy', $bank->id) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm border-0 rounded-circle p-2"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH BANK --}}
<div class="modal fade" id="addBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold text-dark">Tambah Rekening Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bank.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Bank (Contoh: BCA, Mandiri)</label>
                        <input type="text" name="nama_bank" class="form-control border-0 bg-light" required style="border-radius: 10px; padding: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor Rekening</label>
                        <input type="text" name="no_rekening" class="form-control border-0 bg-light" required style="border-radius: 10px; padding: 12px;">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Atas Nama (Pemilik)</label>
                        <input type="text" name="atas_nama" class="form-control border-0 bg-light" required style="border-radius: 10px; padding: 12px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                    <button type="submit" class="btn text-white px-5 py-2 fw-bold rounded-pill" style="background-color: #8B4513;">SIMPAN REKENING</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection