<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi melalui mass assignment.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telp', 
        'alamat',  
        'role',    
        'google_id', // TAMBAHKAN INI: Agar data Google ID bisa disimpan saat login
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    // Relasi ke tabel keranjang
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    // Fungsi cek role admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}