<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $fillable = [
        'user_id',
        'event_type',
        'guest_capacity',
        'ambience',
    ];

}
