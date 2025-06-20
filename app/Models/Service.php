<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'description',
        'price',
        'location'
    ];
}
