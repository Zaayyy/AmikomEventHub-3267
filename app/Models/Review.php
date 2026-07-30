<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'event_id',
        'partner_id',
        'user_id',
        'rating',
        'review',
        'reply',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}