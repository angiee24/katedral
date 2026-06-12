<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        
        $admin = User::updateOrCreate(
            ['email' => 'admin@katedralsamarinda.org'],
            [
                'name' => 'Admin Pusat',
                'email' => 'admin@katedralsamarinda.org',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('admin');

        
        $editor = User::updateOrCreate(
            ['email' => 'editor@katedralsamarinda.org'],
            [
                'name' => 'Editor Katedral',
                'email' => 'editor@katedralsamarinda.org',
                'password' => Hash::make('password123'),
            ]
        );
        $editor->assignRole('editor');

        
        $author = User::updateOrCreate(
            ['email' => 'author@katedralsamarinda.org'],
            [
                'name' => 'Author Komsos',
                'email' => 'author@katedralsamarinda.org',
                'password' => Hash::make('password123'),
            ]
        );
        $author->assignRole('author');
    }
}
