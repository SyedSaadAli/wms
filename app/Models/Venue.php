<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image_name',
        'price',
        'address',
        'user_id',
        'guest_capacity',
        'ambience',
        'event_type'
    ];
}
