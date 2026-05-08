<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Menentukan field yang boleh diisi secara massal
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'date',
        'location',
        'price',
        'stock',
        'poster_path'
    ];

    // Casting tipe data
    protected $casts = [
        'date' => 'datetime',
    ];

    // Relasi: 1 Event dimiliki oleh 1 Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
