<?php

namespace Database\Seeders;

use App\Models\HistoryTimeline;
use Illuminate\Database\Seeder;

class HistoryTimelineSeeder extends Seeder
{
    
    public function run(): void
    {
        $events = [
            [
                'year' => '1907',
                'title' => 'Misi Awal',
                'description' => 'Misi Katolik pertama tiba di wilayah Samarinda, membawa harapan baru dan memulai pelayanan rohani bagi masyarakat lokal di sepanjang sungai Mahakam. Benih iman mulai ditaburkan dengan penuh dedikasi.',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBCPP7gaxtwc_1nOCEy0gyAOqfk0oGahOyebvT-Z2qxKuj4qRaDM0IaZ2S_QlRawkyvNOHB3N4DEJDT23YUC5QNOedmXW2c5FtN9CtPySGPIT_Pov0imsIY6sCu2rdoBDPPL-hsTha1tbUBtkhVV6gUj_LAQ76HqxfyfUNdWHrEVaA70boi0odGfT5cj3doXsrd_f_36Or1OquBiYhIH3EPTqPW_FmvIE7JqNNtihgQT5wBll3HDF5aFfkmllQEURQqSVCpgTEzSOo',
                'order' => 1,
            ],
            [
                'year' => '1950-an',
                'title' => 'Pembangunan Gereja Pertama',
                'description' => 'Seiring bertambahnya umat, gereja paroki pertama dibangun. Struktur kayu sederhana namun kokoh ini menjadi pusat kehidupan menggereja, tempat berkumpulnya komunitas yang semakin solid dalam iman dan persaudaraan.',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB-MWATxjQ77T4XYSVNLd81vrSneXQhLgW4HjLW3S4uLK__TOrBYDyhZ2D4Y4GSt3O6m6OXL2FA07dCVwiRNlMsayMH_9kXflTzZu9KXFAHtiXDSjj-W4XzOcswaeC0B7mng_MLw1DSQDQD_q-U7gjLRGvosIf7fflR-iO0TDkfemraFI_GK5pDlzSo8YTLUlHejHccaDGDN6l9Hl2QjbXyGlkB2QapdhkhqBVCNXB_43rIBz18OLZ7dk4AdOKRDPNEChhh0y1GB1M',
                'order' => 2,
            ],
            [
                'year' => '2003',
                'title' => 'Peningkatan Status Keuskupan Agung',
                'description' => 'Sebuah tonggak sejarah penting ketika Samarinda ditingkatkan statusnya menjadi Keuskupan Agung. Ini menandai kedewasaan gereja lokal dan tanggung jawab yang lebih besar dalam menggembalakan umat di Kalimantan Timur.',
                'image_url' => null,
                'order' => 3,
            ],
            [
                'year' => 'Masa Kini',
                'title' => 'Renovasi Modern & Masa Depan',
                'description' => 'Katedral mengalami renovasi untuk mengakomodasi kebutuhan umat modern dengan tetap mempertahankan nilai historis. Arsitektur megah yang melambangkan keagungan Tuhan, menjadi ikon spiritual dan kebanggaan umat Katolik Samarinda.',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCt0rJfY4QbwD2EhRaauMYiM6ytJhXolBtTx6d0-ruNLs4s_dyHoZDkueGkIirQgKnkzBzjQo11hfQG_lEv3oa6hc6VPZTjCuvtrYN9dlVePG_Xr-0EaxsCzs-skdaEbTZMK-FrxW_cVK1B1DwYsHx3idNgYXvTLPNsA734jdyVQj2hlwq_ct--Kc70RrGcm-4oAjolcT0VkdufsvJJPLhaeCtxmaij3SAw7KKEgtIzQR7kdwC4dIqz9gx6wIEaZELJYxEgx5aq2s0',
                'order' => 4,
            ],
        ];

        foreach ($events as $event) {
            HistoryTimeline::updateOrCreate(
                ['year' => $event['year']],
                $event
            );
        }
    }
}
