<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Coupon;

class Transaction extends Model
{
    protected $fillable = [
        'event_id',
        'coupon_id',
        'order_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_price',
        'discount_amount',
        'status',
        'snap_token',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
