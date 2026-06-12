<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liturgy extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 
        'title',
        'content',
        'event_date',
        'event_time',
        'location',
        'status'
    ];

    protected $casts = [
        'event_date' => 'date',
    ];
}
