<?php

namespace Database\Seeders;

use App\Models\Liturgy;
use Illuminate\Database\Seeder;

class LiturgySeeder extends Seeder
{
    
    public function run(): void
    {
        
        $masses = [
            [
                'type' => 'misa',
                'title' => 'Misa Harian',
                'content' => 'Senin - Jumat',
                'event_date' => now()->format('Y-m-d'),
                'event_time' => '06:00 WITA',
                'location' => 'Gereja Utama Katedral',
                'status' => 'published',
            ],
            [
                'type' => 'misa',
                'title' => 'Misa Jumat Pertama',
                'content' => 'Setiap Jumat pertama awal bulan',
                'event_date' => now()->format('Y-m-d'),
                'event_time' => '18:00 WITA',
                'location' => 'Gereja Utama Katedral',
                'status' => 'published',
            ],
            [
                'type' => 'misa',
                'title' => 'Misa Sabtu Sore',
                'content' => 'Sabtu (Sore) - Antisipasi Hari Minggu',
                'event_date' => now()->addDay()->format('Y-m-d'),
                'event_time' => '18:00 WITA',
                'location' => 'Gereja Utama Katedral',
                'status' => 'published',
            ],
            [
                'type' => 'misa',
                'title' => 'Misa Minggu Pagi I',
                'content' => 'Minggu Pagi I',
                'event_date' => now()->addDays(2)->format('Y-m-d'),
                'event_time' => '07:00 WITA',
                'location' => 'Gereja Utama Katedral',
                'status' => 'published',
            ],
            [
                'type' => 'misa',
                'title' => 'Misa Minggu Pagi II',
                'content' => 'Minggu Pagi II',
                'event_date' => now()->addDays(2)->format('Y-m-d'),
                'event_time' => '09:00 WITA',
                'location' => 'Gereja Utama Katedral',
                'status' => 'published',
            ],
            [
                'type' => 'misa',
                'title' => 'Misa Minggu Sore',
                'content' => 'Minggu Sore',
                'event_date' => now()->addDays(2)->format('Y-m-d'),
                'event_time' => '18:00 WITA',
                'location' => 'Gereja Utama Katedral',
                'status' => 'published',
            ],
        ];

        foreach ($masses as $mass) {
            Liturgy::create($mass);
        }

        
        $announcements = [
            [
                'type' => 'pengumuman',
                'title' => 'Persiapan Sakramen Krisma 2026',
                'content' => 'Pendaftaran calon penerima Sakramen Krisma tahun 2026 telah dibuka di Sekretariat Paroki. Calon peserta wajib mengumpulkan surat baptis terbaru dan mengisi formulir.',
                'event_date' => now()->addDays(3)->format('Y-m-d'),
                'status' => 'published',
            ],
            [
                'type' => 'pengumuman',
                'title' => 'Kerja Bakti Kebersihan Lingkungan Gereja',
                'content' => 'Mengundang seluruh perwakilan wilayah/lingkungan untuk berpartisipasi dalam kerja bakti menyambut Pesta Pelindung Paroki pada hari Sabtu depan mulai pukul 07:30 WITA.',
                'event_date' => now()->addDays(4)->format('Y-m-d'),
                'status' => 'published',
            ],
        ];

        foreach ($announcements as $announcement) {
            Liturgy::create($announcement);
        }

        
        $calendar = [
            [
                'type' => 'kalender',
                'title' => 'Hari Raya Tubuh dan Darah Kristus',
                'content' => 'Perayaan ekaristi khusus disertai prosesi Sakramen Mahakudus.',
                'event_date' => now()->addDays(7)->format('Y-m-d'),
                'status' => 'published',
            ],
            [
                'type' => 'kalender',
                'title' => 'Pesta Nama Pelindung Paroki',
                'content' => 'Misa Syukuran Pesta Nama Pelindung Paroki Katedral Samarinda.',
                'event_date' => now()->addDays(14)->format('Y-m-d'),
                'status' => 'published',
            ],
        ];

        foreach ($calendar as $cal) {
            Liturgy::create($cal);
        }
    }
}
