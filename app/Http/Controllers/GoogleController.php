<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user sudah pernah mendaftar pakai email ini
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Jika belum ada, buatkan akun baru. 
                // Kita beri data bawaan untuk kolom yang wajib diisi.
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => null,
                    'no_telp'   => '-',         // Isi sementara agar database tidak error
                    'alamat'    => '-',         // Isi sementara agar database tidak error
                    'role'      => 'pelanggan', // Set otomatis sebagai pelanggan
                ]);
            } else {
                // Jika email sudah ada, cukup update google_id-nya saja
                $user->update([
                    'google_id' => $googleUser->getId()
                ]);
            }

            // Login otomatis
            Auth::login($user);

            // Arahkan ke halaman utama
            return redirect()->route('home');

        } catch (Exception $e) {
            // Tampilkan error aslinya di layar warna hitam agar kita tahu kalau ada masalah lain
            dd('Gagal login Google. Pesan Error: ' . $e->getMessage());
        }
    }
}