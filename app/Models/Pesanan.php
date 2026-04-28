<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'kode_pesanan', 
        'total_harga', 
        'status', 
        'alamat_pengiriman', 
        'metode_bayar',
        'bukti_bayar' // Kolom baru ditambahkan di sini
    ];

    /**
     * Relasi ke User (Pemesan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Detail Pesanan (Daftar Roti yang dibeli)
     */
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}