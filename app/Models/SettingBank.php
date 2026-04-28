<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingBank extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk memberikan izin pengisian kolom
    protected $fillable = [
        'nama_bank',
        'no_rekening',
        'atas_nama',
        'is_active',
    ];
}