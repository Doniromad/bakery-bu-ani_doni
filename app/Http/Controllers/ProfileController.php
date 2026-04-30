<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        // Tentukan layout berdasarkan role
        $layout = $user->role === 'admin' ? 'layouts.admin' : 'layouts.pelanggan';
        
        return view('profile.edit', compact('user', 'layout'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Validasi no_telp: harus angka dan panjangnya antara 10-15 digit
            'no_telp' => ['nullable', 'numeric', 'digits_between:10,15'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp; // Menyimpan nomor telepon baru

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}