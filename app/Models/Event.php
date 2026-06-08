<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'category_id',
        'organizer_id',
        'title',
        'slug',
        'description',
        'location',
        'strategic_location',
        'date_time',
        'banner_image',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class, 'event_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'event_id');
    }
}
