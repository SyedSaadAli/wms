<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'venue_id',
        'booking_date',
        'guest_count',
        'event_start_time',
        'event_end_time',
        'special_requests',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
