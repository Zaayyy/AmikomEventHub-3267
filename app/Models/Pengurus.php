<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengurus extends Model
{
    use HasFactory;

    // WAJIB karena nama tabel bukan plural Laravel
    protected $table = 'pengurus';

    protected $fillable = [
        'jabatan_id',
        'name',
        'description',
        'salary',
        'created_by',
        'updated_by'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}