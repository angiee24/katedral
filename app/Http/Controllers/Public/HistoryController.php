<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HistoryTimeline;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    
    public function __invoke()
    {
        $vision = Setting::get('church_vision', '');
        $mission = Setting::get('church_mission', '');

        
        $timelines = HistoryTimeline::orderBy('order', 'asc')->get();

        return Inertia::render('Public/Sejarah', [
            'vision' => $vision,
            'mission' => $mission,
            'timelines' => $timelines,
        ]);
    }
}
