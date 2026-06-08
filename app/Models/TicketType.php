<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketType extends Model
{
    protected $fillable = ['event_id', 'name', 'price', 'capacity', 'remaining'];

    protected $casts = [
        'price' => 'decimal:2',
        'capacity' => 'integer',
        'remaining' => 'integer',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'ticket_type_id');
    }
}
