<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    // PERBAIKAN: Daftarkan nama tabelnya (opsional tapi aman)
    protected $table = 'partners';

    // PERBAIKAN UTAMA: Izinkan kolom name dan logo_url untuk mass assignment
    protected $fillable = [
        'name',
        'logo_url'
    ];
}