<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketTier extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'start_date',
        'end_date',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Ticket tier ini milik satu event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
