<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Liturgy;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class LiturgyController extends Controller
{
    use AuthorizesRequests;

    
    public function index(Request $request)
    {
        $this->authorize('manage', Liturgy::class);

        $query = Liturgy::query();

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        $liturgies = $query->orderBy('event_date', 'desc')
            ->orderBy('event_time', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Liturgi/Index', [
            'liturgies' => $liturgies,
            'filters' => $request->only(['type', 'q']),
        ]);
    }

    
    public function store(Request $request)
    {
        $this->authorize('manage', Liturgy::class);

        $validated = $request->validate([
            'type' => 'required|in:misa,pengumuman,kalender',
            'title' => 'required|string|max:150',
            'content' => 'nullable|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
        ]);

        $liturgy = Liturgy::create($validated);

        ActivityLogService::log("Membuat agenda liturgi: [{$liturgy->type}] {$liturgy->title}");

        return redirect()->route('admin.liturgi.index')->with('success', 'Agenda liturgi berhasil ditambahkan.');
    }

    
    public function update(Request $request, Liturgy $liturgi)
    {
        $this->authorize('manage', Liturgy::class);

        $validated = $request->validate([
            'type' => 'required|in:misa,pengumuman,kalender',
            'title' => 'required|string|max:150',
            'content' => 'nullable|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
        ]);

        $liturgi->update($validated);

        ActivityLogService::log("Memperbarui agenda liturgi: {$liturgi->title}");

        return redirect()->route('admin.liturgi.index')->with('success', 'Agenda liturgi berhasil diperbarui.');
    }

    
    public function destroy(Liturgy $liturgi)
    {
        $this->authorize('manage', Liturgy::class);

        $title = $liturgi->title;
        $liturgi->delete();

        ActivityLogService::log("Menghapus agenda liturgi: {$title}");

        return redirect()->route('admin.liturgi.index')->with('success', 'Agenda liturgi berhasil dihapus.');
    }
}
