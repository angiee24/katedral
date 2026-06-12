<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    
    public function index()
    {
        $address = Setting::get('church_address', '');
        $phone = Setting::get('church_phone', '');
        $email = Setting::get('church_email', '');
        $monFri = Setting::get('church_work_hours_mon_fri', '08:00 - 16:00');
        $sat = Setting::get('church_work_hours_sat', '08:00 - 13:00');
        $sun = Setting::get('church_work_hours_sun', 'Tutup');
        $mapsUrl = Setting::get('maps_embed_url', '');
        $mapsLink = Setting::get('church_maps_link', '');

        return Inertia::render('Public/Kontak', [
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'monFri' => $monFri,
            'sat' => $sat,
            'sun' => $sun,
            'mapsUrl' => $mapsUrl,
            'mapsLink' => $mapsLink,
        ]);
    }

    
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Sekretariat paroki akan segera menindaklanjuti.');
    }
}
