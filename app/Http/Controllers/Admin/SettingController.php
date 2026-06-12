<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\HistoryTimeline;
use App\Models\Media;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SettingController extends Controller
{
    
    public function index()
    {
        if (!Auth::user()->hasPermission('manage-settings')) {
            abort(403);
        }

        $settings = Setting::pluck('value', 'key')->toArray();
        $timelines = HistoryTimeline::orderBy('order', 'asc')->get();
        $mediaFiles = Media::orderBy('created_at', 'desc')->get();

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
            'timelines' => $timelines,
            'mediaFiles' => $mediaFiles,
        ]);
    }

    
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('manage-settings')) {
            abort(403);
        }

        $validated = $request->validate([
            'church_name' => 'required|string|max:100',
            'church_address' => 'required|string|max:250',
            'church_phone' => 'required|string|max:50',
            'church_email' => 'required|email|max:100',
            'church_work_hours_mon_fri' => 'required|string|max:100',
            'church_work_hours_sat' => 'required|string|max:100',
            'church_work_hours_sun' => 'required|string|max:100',
            'church_vision' => 'required|string|max:500',
            'church_mission' => 'required|string',
            'banner_title' => 'required|string|max:200',
            'banner_subtitle' => 'required|string|max:500',
            'banner_image' => 'required|string', 
            'maps_embed_url' => 'nullable|string',
            'church_maps_link' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        ActivityLogService::log('Memperbarui pengaturan website');

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan website berhasil disimpan.');
    }

    
    public function storeTimeline(Request $request)
    {
        if (!Auth::user()->hasPermission('manage-settings')) {
            abort(403);
        }

        $validated = $request->validate([
            'year' => 'required|string|max:20',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $timeline = HistoryTimeline::create($validated);

        ActivityLogService::log("Menambahkan tonggak sejarah baru: {$timeline->year} - {$timeline->title}");

        return redirect()->route('admin.settings.index')->with('success', 'Tonggak sejarah berhasil ditambahkan.');
    }

    
    public function updateTimeline(Request $request, HistoryTimeline $timeline)
    {
        if (!Auth::user()->hasPermission('manage-settings')) {
            abort(403);
        }

        $validated = $request->validate([
            'year' => 'required|string|max:20',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $timeline->update($validated);

        ActivityLogService::log("Memperbarui tonggak sejarah: {$timeline->year}");

        return redirect()->route('admin.settings.index')->with('success', 'Tonggak sejarah berhasil diperbarui.');
    }

    
    public function destroyTimeline(HistoryTimeline $timeline)
    {
        if (!Auth::user()->hasPermission('manage-settings')) {
            abort(403);
        }

        $year = $timeline->year;
        $timeline->delete();

        ActivityLogService::log("Menghapus tonggak sejarah: {$year}");

        return redirect()->route('admin.settings.index')->with('success', 'Tonggak sejarah berhasil dihapus.');
    }
}
