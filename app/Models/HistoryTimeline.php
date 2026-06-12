<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTimeline extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'title', 'description', 'image_url', 'order'];
}
