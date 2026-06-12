<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class YoutubeStreamSeeder extends Seeder
{
    
    public function run(): void
    {
        
        $categoryLiturgi = Category::firstOrCreate(
            ['slug' => 'liturgi'],
            ['name' => 'Liturgi', 'description' => 'Info peribadatan dan perayaan liturgis']
        );
        $categoryKomunitas = Category::firstOrCreate(
            ['slug' => 'komunitas'],
            ['name' => 'Komunitas', 'description' => 'Info seputar kegiatan komunitas paroki']
        );
        $categoryKeluargaOMK = Category::firstOrCreate(
            ['slug' => 'keluarga-orang-muda'],
            ['name' => 'Keluarga & Orang Muda', 'description' => 'Kegiatan OMK dan keluarga paroki']
        );

        
        $author = User::where('email', 'author@katedralsamarinda.org')->first() 
            ?? User::where('email', 'admin@katedralsamarinda.org')->first()
            ?? User::first();

        if (!$author) {
            $this->command->error('User tidak ditemukan. Pastikan seeder User sudah dijalankan.');
            return;
        }

        
        $streams = [
            [
                'title' => 'Misa Rabu Abu',
                'slug' => 'misa-rabu-abu-2026',
                'video_id' => 'zwHS2o1f5u8',
                'image_name' => 'Misa Rabu Abu. Rabu, 18 Februari 2026, Jam 1800 WITA..avif',
                'published_at' => '2026-02-18 18:00:00',
                'excerpt' => 'Saksikan siaran ulang Misa Rabu Abu yang dilangsungkan pada hari Rabu, 18 Februari 2026 pukul 18:00 WITA.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Misa Rabu Abu menandai awal Masa Prapaskah tahun 2026.</p>
<p>Umat diajak memasuki masa pertobatan, doa, puasa, dan pantang selama 40 hari menjelang Paskah. Melalui tanda abu di dahi, kita diingatkan kembali akan asal dan tujuan hidup kita di hadapan Allah.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/zwHS2o1f5u8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>
<p>Bagi Anda yang berhalangan hadir langsung atau ingin mengikuti renungan kembali, Anda dapat menonton rekaman siaran langsung misa di atas.</p>'
            ],
            [
                'title' => 'Ibadat Jalan Salib & Perayaan Ekaristi',
                'slug' => 'ibadat-jalan-salib-perayaan-ekaristi-2026',
                'video_id' => 'NnIXmSNoUHU',
                'image_name' => 'Ibadat Jalan Salib & Perayaan Ekarist.webp',
                'published_at' => '2026-02-20 18:00:00',
                'excerpt' => 'Saksikan rekaman siaran langsung Ibadat Jalan Salib dilanjutkan Perayaan Ekaristi hari Jumat, 20 Februari 2026.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Merenungkan sengsara Kristus di sepanjang jalan salib.</p>
<p>Jumat pertama di masa Prapaskah ini diawali dengan perenungan kisah sengsara Yesus Kristus melalui Ibadat Jalan Salib, yang kemudian disempurnakan dengan bersatu dalam perjamuan kudus Perayaan Ekaristi.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/NnIXmSNoUHU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>
<p>Siaran langsung ini disediakan oleh Tim Komunikasi Paroki agar umat sakit dan lansia dapat turut berdoa bersama dari rumah.</p>'
            ],
            [
                'title' => 'Misa Hari Minggu Prapaskah I & Missio Canonica',
                'slug' => 'misa-minggu-prapaskah-i-missio-canonica',
                'video_id' => 'q9BmEZF4n9c',
                'image_name' => 'Misa Hari Minggu Pra Paskah I dan Missio Canonica.webp',
                'published_at' => '2026-02-22 08:30:00',
                'excerpt' => 'Siaran langsung Ekaristi Minggu Prapaskah I sekaligus penyerahan Missio Canonica bagi para katekis dan pelayan paroki.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Ekaristi Minggu Prapaskah I dan Upacara Pengutusan Pelayan Paroki.</p>
<p>Perayaan ekaristi suci pada hari Minggu, 22 Februari 2026 dirangkai dengan penyerahan perutusan resmi (Missio Canonica) kepada para pelayan katekis, guru agama Katolik, dan pembina iman di Paroki Katedral Samarinda.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/q9BmEZF4n9c" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>
<p>Mari kita doakan para pelayan paroki kita agar senantiasa setia dalam mengemban misi pewartaan kabar gembira Kristus.</p>'
            ],
            [
                'title' => 'Perayaan Ekaristi Minggu Palma - Misa Pagi 09:00 WITA',
                'slug' => 'perayaan-ekaristi-minggu-palma-09-00-wita',
                'video_id' => 'Ez3YIaLpCO8',
                'image_name' => 'Perayaan Ekaristi Minggu Palma 09.00.webp',
                'published_at' => '2026-03-29 09:00:00',
                'excerpt' => 'Saksikan siaran langsung Misa Pagi Hari Minggu Palma mengenangkan sengsara Tuhan Yesus dari Katedral Samarinda.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Memasuki Pekan Suci dengan Perarakan Daun Palma.</p>
<p>Misa pagi hari Minggu Palma diawali dengan upacara pemberkatan daun-daun palma dan perarakan meriah masuk ke dalam gereja sebagai tanda penyambutan Kristus Raja kita yang bersedia menanggung sengsara demi penebusan dosa umat manusia.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/Ez3YIaLpCO8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>
<p>Misa pagi ini ditayangkan secara langsung pada pukul 09:00 WITA untuk seluruh umat paroki.</p>'
            ],
            [
                'title' => 'Perayaan Ekaristi Minggu Palma - Misa Sore 18:00 WITA',
                'slug' => 'perayaan-ekaristi-minggu-palma-18-00-wita',
                'video_id' => 'PnxsQeNV5X0',
                'image_name' => 'Perayaan Ekaristi Minggu Palma 18.00.webp',
                'published_at' => '2026-03-29 18:00:00',
                'excerpt' => 'Saksikan siaran langsung Misa Sore Hari Minggu Palma mengenangkan sengsara Tuhan Yesus.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Misa Penutup Hari Minggu Palma Pekan Suci.</p>
<p>Siaran ulang dan siaran langsung Misa Sore Hari Minggu Palma jam 18:00 WITA. Mari persiapkan hati kita memasuki Trihari Suci melalui keheningan dan pertobatan batin yang mendalam.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/PnxsQeNV5X0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Perayaan Ekaristi Misa Kamis Putih',
                'slug' => 'perayaan-ekaristi-misa-kamis-putih-2026',
                'video_id' => 'ghiWGnoc8Sg',
                'image_name' => 'Perayaan Ekaristi Kamis Putih.webp',
                'published_at' => '2026-04-02 17:00:00',
                'excerpt' => 'Saksikan siaran langsung perayaan Ekaristi Misa Kamis Putih mengenangkan perjamuan malam terakhir Tuhan Yesus.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Kamis Putih: Pembasuhan Kaki dan Penetapan Sakramen Ekaristi.</p>
<p>Dalam perayaan Ekaristi Kamis Putih, kita mengenang kembali perjamuan malam terakhir yang dilakukan Yesus bersama murid-murid-Nya. Di dalam misa ini juga dilangsungkan prosesi pembasuhan kaki para murid sebagai teladan pelayanan kasih.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/ghiWGnoc8Sg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>
<p>Umat diajak untuk hening menyembah Sakramen Maha Kudus (Tuguran) selepas ibadat ini selesai.</p>'
            ],
            [
                'title' => 'Ibadat Jumat Agung - Pukul 12:00 WITA',
                'slug' => 'ibadat-jumat-agung-12-00-wita',
                'video_id' => 'JnkZ03ggn_k',
                'image_name' => 'ibadat Jumat Agung 12.00.webp',
                'published_at' => '2026-04-03 12:00:00',
                'excerpt' => 'Siaran langsung Ibadat Sengsara dan Wafat Yesus Kristus di kayu salib dari Katedral Samarinda sesi pertama.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Mengenang Wafatnya Sang Penebus Dunia.</p>
<p>Ibadat Jumat Agung sesi pertama yang dilangsungkan tepat pada pukul 12:00 WITA. Mari bersama-sama bersujud dalam doa hening di bawah kaki salib Yesus.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/JnkZ03ggn_k" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Ibadat Jumat Agung - Pukul 15:00 WITA',
                'slug' => 'ibadat-jumat-agung-15-00-wita',
                'video_id' => 'IZT8IcHtjx0',
                'image_name' => 'ibadat Jumat Agung 15.00.webp',
                'published_at' => '2026-04-03 15:00:00',
                'excerpt' => 'Siaran langsung Ibadat Sengsara dan Wafat Yesus Kristus di kayu salib sesi kedua dari Katedral Samarinda.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Saat-saat Wafat Tuhan Yesus di Kayu Salib.</p>
<p>Ibadat Jumat Agung pada pukul 15:00 WITA, saat di mana Yesus wafat menyerahkan nyawa-Nya ke dalam tangan Bapa. Dilakukan pembacaan kisah sengsara (Passio) secara agung dan Upacara Penghormatan Salib Suci.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/IZT8IcHtjx0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Perayaan Ekaristi Malam Paskah - Misa 17:00 WITA',
                'slug' => 'perayaan-ekaristi-malam-paskah-17-00-wita',
                'video_id' => '-VRlfwBfFdM',
                'image_name' => 'Perayaan Ekaristi Malam Paskah 17.00.webp',
                'published_at' => '2026-04-04 17:00:00',
                'excerpt' => 'Siaran langsung Misa Malam Paskah (Tirakatan Kebangkitan Tuhan) sesi sore pukul 17:00 WITA.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Malam Tirakatan Kebangkitan Kristus.</p>
<p>Misa Malam Paskah pertama pada pukul 17:00 WITA. Meliputi Upacara Cahaya (pemberkatan api baru dan lilin Paskah), Liturgi Sabda sejarah keselamatan, pembaharuan janji baptis, dan liturgi Ekaristi Kudus yang meriah.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/-VRlfwBfFdM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Perayaan Ekaristi Malam Paskah - Misa 20:30 WITA',
                'slug' => 'perayaan-ekaristi-malam-paskah-20-30-wita',
                'video_id' => 'RLnrhh_VLJg',
                'image_name' => 'Perayaan Ekaristi Malam Paskah 20.30.webp',
                'published_at' => '2026-04-04 20:30:00',
                'excerpt' => 'Siaran langsung Misa Malam Paskah (Tirakatan Kebangkitan Tuhan) sesi kedua pukul 20:30 WITA.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Merayakan Kemenangan Kristus atas Maut.</p>
<p>Misa Malam Paskah kedua pada pukul 20:30 WITA. Mari bersama bersyukur atas karunia hidup baru dan terang kebangkitan Kristus yang menghalau kegelapan dosa kita.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/RLnrhh_VLJg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Perayaan Ekaristi Hari Raya Paskah',
                'slug' => 'perayaan-ekaristi-hari-raya-paskah-2026',
                'video_id' => 'QELc3PIckdk',
                'image_name' => 'Perayaan Ekaristi Hari Raya Paskah.webp',
                'published_at' => '2026-04-05 08:30:00',
                'excerpt' => 'Saksikan siaran langsung Perayaan Ekaristi Hari Raya Paskah (Misa Kebangkitan Tuhan) pukul 08:30 WITA.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Kristus Telah Bangkit! Alleluia!</p>
<p>Puncak kegembiraan dan iman kristiani kita terwujud dalam Misa Kebangkitan Tuhan Yesus Kristus. Kubur kosong menjadi bukti janji keselamatan-Nya tergenapi.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/QELc3PIckdk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Perayaan Ekaristi Hari Raya Kenaikan Tuhan',
                'slug' => 'perayaan-ekaristi-hari-raya-kenaikan-tuhan-2026',
                'video_id' => 'YkcVRJozcug',
                'image_name' => 'Perayaan Ekaristi Hari Raya Kenaikan Tuhan.webp',
                'published_at' => '2026-05-14 18:00:00',
                'excerpt' => 'Saksikan siaran langsung Perayaan Ekaristi Hari Raya Kenaikan Tuhan Yesus Kristus ke Surga.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Yesus Naik ke Surga untuk Menyediakan Tempat Bagi Kita.</p>
<p>Perayaan Misa Kenaikan Tuhan Yesus Kristus ke Surga. Kita diutus menjadi saksi-saksi Kristus dan membawa damai sejahtera bagi sesama di mana pun kita berada.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/YkcVRJozcug" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Perayaan Ekaristi Hari Minggu Paskah VII',
                'slug' => 'perayaan-ekaristi-hari-minggu-paskah-vii-2026',
                'video_id' => 'CA3zOmi7Wlk',
                'image_name' => 'Perayaan Ekaristi Hari Hari Minggu Paskah VII.webp',
                'published_at' => '2026-05-17 08:30:00',
                'excerpt' => 'Siaran langsung Perayaan Ekaristi Hari Minggu Paskah VII dari Katedral Samarinda.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Masa Paskah Menjelang Pentakosta.</p>
<p>Perayaan Misa Minggu Paskah VII. Kita menanti dengan tekun pencurahan Roh Kudus bersama Bunda Maria dan para rasul dalam doa-doa novena kita.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/CA3zOmi7Wlk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Perayaan Ekaristi Hari Raya Pentakosta',
                'slug' => 'perayaan-ekaristi-hari-raya-pentakosta-2026',
                'video_id' => 'ze5Xa_IX1fQ',
                'image_name' => 'Perayaan Ekaristi Hari Raya Pentakosta.webp',
                'published_at' => '2026-05-24 08:30:00',
                'excerpt' => 'Saksikan siaran langsung Perayaan Ekaristi Hari Raya Pentakosta merayakan pencurahan Roh Kudus.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Pentakosta: Roh Kudus Datang Memperbarui Muka Bumi.</p>
<p>Hari Raya Pentakosta merayakan karunia Roh Kudus atas para rasul, menandai lahirnya Gereja secara resmi dan dimulainya misi pewartaan iman bagi segala bangsa.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/ze5Xa_IX1fQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
            [
                'title' => 'Perayaan Ekaristi Hari Raya Tubuh dan Darah Kristus',
                'slug' => 'perayaan-ekaristi-hari-raya-tubuh-dan-darah-kristus-2026',
                'video_id' => '4OAbnAyCLCc',
                'image_name' => 'Perayaan Ekaristi HR Tubuh dan Darah Kristus.webp',
                'published_at' => '2026-06-07 08:30:00',
                'excerpt' => 'Saksikan siaran langsung Perayaan Ekaristi Hari Raya Tubuh dan Darah Kristus dari Paroki Katedral Samarinda.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Ekaristi: Tubuh dan Darah Kristus yang Menghidupkan Kita.</p>
<p>Hari Raya Tubuh dan Darah Kristus. Kita merayakan persatuan rohani yang mendalam bersama Kristus lewat rupa Roti dan Anggur Ekaristi yang menghidupkan dan menyatukan persekutuan umat beriman.</p>
<div class="my-8 aspect-video w-full rounded-xl overflow-hidden shadow-md border border-outline-variant/30">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/4OAbnAyCLCc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>'
            ],
        ];

        
        foreach ($streams as $stream) {
            $imageUrl = "/images/{$stream['image_name']}";
            
            
            $media = Media::updateOrCreate(
                ['url' => $imageUrl],
                [
                    'filename' => $stream['image_name'],
                    'filepath' => "images/{$stream['image_name']}",
                    'mime_type' => 'image/webp',
                    'size' => 150000,
                    'user_id' => $author->id,
                ]
            );

            
            Post::updateOrCreate(
                ['slug' => $stream['slug']],
                [
                    'title' => $stream['title'],
                    'excerpt' => $stream['excerpt'],
                    'content' => $stream['content'],
                    'media_id' => $media->id,
                    'category_id' => $categoryLiturgi->id,
                    'user_id' => $author->id,
                    'status' => 'published',
                    'published_at' => $stream['published_at'],
                    'is_featured' => ($stream['slug'] === 'perayaan-ekaristi-hari-raya-tubuh-dan-darah-kristus-2026')
                ]
            );
        }

        
        $baksosMedia = Media::updateOrCreate(
            ['url' => '/images/bakti_sosial.png'],
            [
                'filename' => 'bakti_sosial.png',
                'filepath' => 'images/bakti_sosial.png',
                'mime_type' => 'image/png',
                'size' => 2414779,
                'user_id' => $author->id,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'bakti-social-stasi-berambai-2026'],
            [
                'title' => 'Bakti Sosial Masa Prapaskah 2026 di Stasi Berambai',
                'excerpt' => 'Penyuluhan dan pemeriksaan kesehatan gratis di Berambai diadakan oleh DPP Paroki Katedral Samarinda Bidang Diakonia.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Penyuluhan dan Pemeriksaan Kesehatan Gratis di Berambai.</p>
<p>Dalam rangka aksi sosial menyambut Masa Prapaskah 2026, Dewan Pastoral Paroki (DPP) Katedral Santa Maria Penolong Abadi Samarinda melalui Bidang Diakonia menyelenggarakan Bakti Sosial berupa penyuluhan dan pemeriksaan kesehatan gratis.</p>
<p>Kegiatan kemanusiaan ini dilangsungkan pada hari Minggu, 22 Februari 2026 bertempat di Dusun Berambai, Desa Bukit Pariaman, Kecamatan Tenggarong Seberang, Kutai Kartanegara.</p>
<p>Acara ini diikuti oleh warga Dusun Berambai dengan sangat antusias dan turut dihadiri langsung oleh Bapak Sugeng Riyadi selaku Kepala Desa Bukit Pariaman. Warga mengantri dengan tertib untuk diperiksa kesehatannya dan diberikan obat secara gratis oleh petugas medis. Disampaikan pula pengarahan serta himbauan pola hidup sehat dan bersih agar warga dapat terhindar dari penyakit musiman.</p>
<div class="bg-[#F7F3EB] p-8 rounded-xl my-8 border-l-4 border-primary">
    <p class="font-headline-md text-headline-md text-on-background italic mb-0">"Kami mengapresiasi dan berterima kasih atas aksi peduli kasih dari Paroki Katedral Samarinda yang bersedia melayani umat dan warga Dusun Berambai."</p>
    <p class="font-label-md text-label-md text-primary mt-4">— Bpk. Sugeng Riyadi, Kepala Desa Bukit Pariaman</p>
</div>
<p>Semoga kegiatan ini membawa berkat rohani dan jasmani bagi seluruh masyarakat dalam menyambut Masa Prapaskah yang suci.</p>',
                'media_id' => $baksosMedia->id,
                'category_id' => $categoryKomunitas->id,
                'user_id' => $author->id,
                'status' => 'published',
                'published_at' => '2026-02-22 13:00:00',
                'is_featured' => false
            ]
        );

        
        $omkMedia = Media::updateOrCreate(
            ['url' => '/images/temu_omk.jpg'],
            [
                'filename' => 'temu_omk.jpg',
                'filepath' => 'images/temu_omk.jpg',
                'mime_type' => 'image/jpeg',
                'size' => 18668,
                'user_id' => $author->id,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'temu-omk-kevikepan-mahakam-ilir-2026'],
            [
                'title' => 'Temu Orang Muda Katolik (OMK) Kevikepan Mahakam Ilir Sukses Diselenggarakan',
                'excerpt' => 'Pertemuan kaum muda Katolik tingkat kevikepan dipenuhi dinamika kelompok, pembekalan iman, aksi sosial, dan Ekaristi Raya.',
                'content' => '<p class="font-headline-md text-headline-md text-primary mb-6">Membina Iman dan Kebersamaan Orang Muda Katolik di Katedral Samarinda.</p>
<p>Temu Orang Muda Katolik (OMK) Kevikepan Mahakam Ilir telah sukses diselenggarakan di Gereja Katedral Santa Maria Penolong Abadi Samarinda pada tanggal 14–17 Mei 2026.</p>
<p>Acara akbar ini diikuti oleh ratusan kaum muda perwakilan dari paroki-paroki se-kevikepan. Selama empat hari, peserta mengikuti rangkaian pembekalan spiritual dan sosial, dinamika kelompok, aksi kepedulian lingkungan, dan ditutup dengan perayaan Ekaristi Raya yang agung.</p>
<div class="bg-[#F7F3EB] p-8 rounded-xl my-8 border border-[#e7c185]/30 flex flex-col gap-4 items-center text-center">
    <span class="material-symbols-outlined text-primary text-4xl">photo_camera</span>
    <h4 class="font-headline-md text-on-background">Dokumentasi & Keseruan Acara</h4>
    <p class="font-body-md text-on-surface-variant">Untuk melihat galeri foto lengkap, rekap keseruan acara, serta update informasi kegiatan pemuda Katolik terbaru, silakan kunjungi akun Instagram resmi OMK Katedral Samarinda.</p>
    <a href="https://www.instagram.com/omkkatedralsmd/" target="_blank" rel="noopener noreferrer" class="bg-primary text-on-primary font-label-md text-label-md px-6 py-3 rounded-lg uppercase tracking-wider hover:opacity-95 transition-opacity inline-flex items-center gap-2">
        <span class="material-symbols-outlined">link</span> Instagram @omkkatedralsmd
    </a>
</div>
<p>Semoga kegiatan ini memicu semangat baru bagi kaum muda Katolik untuk berani bersaksi, melayani, dan merasul dengan giat di tengah masyarakat luas. Terima kasih kepada seluruh panitia pelaksana dan pihak paroki yang mendukung kesuksesan perjumpaan rohani ini!</p>',
                'media_id' => $omkMedia->id,
                'category_id' => $categoryKeluargaOMK->id,
                'user_id' => $author->id,
                'status' => 'published',
                'published_at' => '2026-05-17 18:00:00',
                'is_featured' => false
            ]
        );
    }
}
