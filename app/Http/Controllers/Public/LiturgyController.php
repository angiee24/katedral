<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Liturgy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LiturgyController extends Controller
{
    
    public function __invoke()
    {
        
        $masses = Liturgy::where('type', 'misa')
            ->where('status', 'published')
            ->get();

        
        $announcements = Liturgy::where('type', 'pengumuman')
            ->where('status', 'published')
            ->where('event_date', '>=', now()->startOfDay())
            ->orderBy('event_date', 'asc')
            ->get();

        
        $calendar = Liturgy::where('type', 'kalender')
            ->where('status', 'published')
            ->where('event_date', '>=', now()->startOfDay())
            ->orderBy('event_date', 'asc')
            ->get();

        return Inertia::render('Public/Liturgi', [
            'masses' => $masses,
            'announcements' => $announcements,
            'calendar' => $calendar,
        ]);
    }
}
