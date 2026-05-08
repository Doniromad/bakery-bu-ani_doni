@extends('layouts.admin')

@section('title', 'Manajemen Kategori - Bakery Bu Ani')

@section('content')
<div class="container-fluid px-0 px-md-3 py-3 py-md-4">
    
    {{-- Header Halaman dengan Tombol Kembali (Sama dengan Tambah Produk) --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.produk.index') }}" class="btn btn-light rounded-circle shadow-sm me-3 border bg-white" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left text-dark"></i>
        </a>
        <div style="width: 5px; height: 25px; background-color: #8B4513; border-radius: 10px;" class="me-3"></div>
        <h4 class="fw-bold m-0 text-dark text-uppercase fs-5 fs-md-4" style="letter-spacing: 1px;">Manajemen Kategori</h4>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    {{-- Card Tabel Kategori --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- Header Card Cokelat --}}
        <div class="card-header border-0 py-3 d-flex justify-content-between align-items-center" style="background-color: #8B4513;">
            <h6 class="m-0 font-weight-bold text-white uppercase small"><i class="bi bi-grid-3x3-gap me-2"></i> Daftar Kategori Roti</h6>
            <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah" style="font-size: 0.75rem;">
             TAMBAH KATEGORI
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #fdf2e9;">
                        <tr class="small text-muted text-uppercase">
                            <th class="ps-4 py-3 border-0" style="letter-spacing: 1px;">Nama Kategori</th>
                            <th class="py-3 border-0" style="letter-spacing: 1px;">Slug (URL)</th>
                            <th class="pe-4 py-3 text-center border-0" style="letter-spacing: 1px; width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $k)
                        <tr class="category-row">
                            <td class="ps-4 py-3">
                                <h6 class="fw-bold mb-0 text-dark small">{{ $k->nama }}</h6>
                            </td>
                            <td class="py-3 text-muted">
                                <code class="small" style="color: #8B4513;">{{ $k->slug }}</code>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-light btn-sm rounded-circle shadow-sm p-2 hover-scale" 
                                            data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}" title="Edit">
                                        <i class="bi bi-pencil-square text-info"></i>
                                    </button>
                                    <form action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm p-2 hover-scale" title="Hapus">
                                            <i class="bi bi-trash3 text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $k->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header border-0 py-3" style="background-color: #8B4513; border-radius: 15px 15px 0 0;">
                                        <h6 class="modal-title text-white fw-bold uppercase small"><i class="bi bi-pencil-square me-2"></i> Edit Kategori</h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.kategori.update', $k->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-0">
                                                <label class="form-label small fw-bold text-muted uppercase">NAMA KATEGORI</label>
                                                <input type="text" name="nama" class="form-control rounded-3 bg-light border-0 py-2" value="{{ $k->nama }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 pt-0">
                                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold" style="background-color: #8B4513; border:none;">SIMPAN PERUBAHAN</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 py-3" style="background-color: #8B4513; border-radius: 15px 15px 0 0;">
                <h6 class="modal-title text-white fw-bold uppercase small"><i class="bi bi-plus-circle me-2"></i> Tambah Kategori Baru</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted uppercase">NAMA KATEGORI</label>
                        <input type="text" name="nama" class="form-control rounded-3 bg-light border-0 py-2" placeholder="Masukkan nama kategori..." required autofocus>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold" style="background-color: #8B4513; border:none;">TAMBAHKAN KATEGORI</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Styling Sidebar State */
    .category-row { transition: all 0.2s ease; border-left: 4px solid transparent; }
    .category-row:hover { background-color: #fdfaf8 !important; border-left: 4px solid #8B4513; }
    .hover-scale:hover { transform: scale(1.1); transition: 0.2s; }
</style>
@endsection