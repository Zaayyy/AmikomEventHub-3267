<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'partner_id',
        'title',
        'description',
        'date',
        'location',
        'price',
        'stock',
        'poster_path',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Relasi ke kategori event
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke partner/penyelenggara
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Relasi ke review
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Menghitung rata-rata rating
     */
    public function averageRating()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function transactions()
{
    return $this->hasMany(Transaction::class);
}
}