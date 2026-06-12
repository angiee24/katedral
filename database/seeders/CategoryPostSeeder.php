<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryPostSeeder extends Seeder
{
    
    public function run(): void
    {
        
        $categories = [
            ['name' => 'Liturgi', 'slug' => 'liturgi', 'description' => 'Info peribadatan dan perayaan liturgis'],
            ['name' => 'Komunitas', 'slug' => 'komunitas', 'description' => 'Info seputar kegiatan komunitas paroki'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Pengumuman penting sekretariat paroki'],
            ['name' => 'Keluarga & Orang Muda', 'slug' => 'keluarga-orang-muda', 'description' => 'Kegiatan OMK dan keluarga paroki'],
        ];

        $categoryModels = [];
        foreach ($categories as $category) {
            $categoryModels[$category['slug']] = Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        
        $tags = [
            ['name' => 'Pekan Suci', 'slug' => 'pekan-suci'],
            ['name' => 'Misa', 'slug' => 'misa'],
            ['name' => 'OMK', 'slug' => 'omk'],
            ['name' => 'Rosario', 'slug' => 'rosario'],
            ['name' => 'Komuni Pertama', 'slug' => 'komuni-pertama'],
        ];

        $tagModels = [];
        foreach ($tags as $tag) {
            $tagModels[$tag['slug']] = Tag::updateOrCreate(
                ['slug' => $tag['slug']],
                $tag
            );
        }

        
        $authorUser = User::where('email', 'author@katedralsamarinda.org')->first()
            ?? User::first();
    }
}
