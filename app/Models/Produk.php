<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    /**
     * Pastikan 'kategori_id' masuk ke fillable agar bisa disimpan 
     * saat proses CRUD di Admin.
     */
    protected $fillable = [
        'kategori_id', 
        'nama_produk', 
        'deskripsi', 
        'harga', 
        'stok', 
        'gambar'
    ];

    /**
     * Relasi ke model Kategori
     * Satu produk termasuk dalam satu kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke detail pesanan (tetap dipertahankan)
     */
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}