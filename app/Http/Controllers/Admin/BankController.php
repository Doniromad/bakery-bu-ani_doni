<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingBank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    // Tampilkan daftar bank
    public function index()
    {
        $banks = SettingBank::latest()->get();
        return view('admin.bank.index', compact('banks'));
    }

    // Simpan bank baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_bank'   => 'required|string|max:50',
            'no_rekening' => 'required|string|max:30',
            'atas_nama'   => 'required|string|max:100',
        ]);

        SettingBank::create([
            'nama_bank'   => strtoupper($request->nama_bank),
            'no_rekening' => $request->no_rekening,
            'atas_nama'   => strtoupper($request->atas_nama),
            'is_active'   => true, // Otomatis aktif saat dibuat
        ]);

        return back()->with('success', 'Rekening bank berhasil ditambahkan!');
    }

    // Hapus bank
    public function destroy($id)
    {
        $bank = SettingBank::findOrFail($id);
        $bank->delete();

        return back()->with('success', 'Rekening bank berhasil dihapus!');
    }

    // Opsional: Jika ingin tambah fitur aktivasi/non-aktifkan bank
    public function toggleStatus($id)
    {
        $bank = SettingBank::findOrFail($id);
        $bank->is_active = !$bank->is_active;
        $bank->save();

        return back()->with('success', 'Status bank berhasil diubah!');
    }
}