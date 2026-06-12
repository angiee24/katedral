<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    
    public function run(): void
    {
        $settings = [
            'church_name' => 'Gereja Katedral Samarinda',
            'church_address' => 'Jl. Jend. Sudirman No.40, Bugis, Kec. Samarinda Kota, Kota Samarinda, Kalimantan Timur 75122',
            'church_phone' => '(0541) 742002',
            'church_email' => 'sekretariat@katedralsamarinda.org',
            'church_work_hours_mon_fri' => '08:00 - 16:00',
            'church_work_hours_sat' => '08:00 - 13:00',
            'church_work_hours_sun' => 'Tutup',
            'church_vision' => 'Menjadi persekutuan umat beriman yang tangguh, mandiri, dan misioner, berakar pada cinta kasih Kristus serta turut serta membangun masyarakat yang damai and sejahtera di tengah keberagaman budaya.',
            'church_mission' => "1. Merayakan iman melalui liturgi yang agung, khusyuk, dan partisipatif, membawa umat semakin dekat dengan misteri keselamatan.\n2. Membangun komunitas basis yang kuat, saling peduli, dan mendampingi kaum muda serta keluarga dalam peziarahan iman.\n3. Mewujudkan cinta kasih nyata kepada mereka yang miskin, tersingkir, dan menderita, menjadi garam dan terang di tengah masyarakat luas.",
            'banner_title' => 'Selamat Datang di Portal Gereja Katedral Samarinda',
            'banner_subtitle' => 'Situs resmi paroki untuk berbagi warta, memperdalam iman, dan merajut persaudaraan dalam kasih Kristus. Mari bertumbuh bersama dalam terang.',
            'banner_image' => '/images/katedral_hero_section.jpg',
            'maps_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6800720485925!2d117.14917997380907!3d-0.4972599352668551!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f13c2f0f0cb%3A0x1a8fb1d76378c8a1!2sKatedral%20Santa%20Maria%20Penolong%20Abadi%2C%20Samarinda!5e0!3m2!1sid!2sid!4v1718163000000!5m2!1sid!2sid',
            'church_maps_link' => 'https://www.google.com/maps?gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIICAEQABgNGB4yCAgCEAAYDRgeMggIAxAAGA0YHjIMCAQQABgFGAoYDRgeMgoIBRAAGAUYDRgeMgoIBhAAGAgYDRgeMgoIBxAAGAgYDRgeMgoICBAAGAgYDRgeMgoICRAAGAgYDRge0gEINDgwMGowajmoAgCwAgA&um=1&ie=UTF-8&fb=1&gl=id&sa=X&geocode=KeEW88YJf_YtMfQb0XxS2NHO&daddr=Jl.+Jend.+Sudirman+No.40,+Bugis,+Kec.+Samarinda+Kota,+Kota+Samarinda,+Kalimantan+Timur+75122'
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
