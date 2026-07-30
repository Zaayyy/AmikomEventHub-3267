<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by'
    ];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }
}