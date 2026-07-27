<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_url',
        'user_id',
        'status',
    ];

    // Partner memiliki satu akun User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Partner memiliki banyak event
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Partner memiliki banyak review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
