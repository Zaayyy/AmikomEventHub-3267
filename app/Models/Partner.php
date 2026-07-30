<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_url',
        'description',
    ];

    public function user()
    {
    return $this->hasOne(User::class);
    }

    /**
     * Relasi Partner -> Event
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Mengambil seluruh review dari event milik partner
     */
    public function reviews()
    {
        return Review::whereHas('event', function ($query) {
            $query->where('partner_id', $this->id);
        });
    }

    /**
     * Menghitung rata-rata rating
     */
    public function averageRating()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}