<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    
    public function run(): void
    {
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        
        $permissions = [
            ['name' => 'manage-users', 'guard_name' => 'web'],
            ['name' => 'manage-settings', 'guard_name' => 'web'],
            ['name' => 'manage-liturgies', 'guard_name' => 'web'],
            ['name' => 'manage-categories', 'guard_name' => 'web'],
            ['name' => 'manage-posts', 'guard_name' => 'web'],
            ['name' => 'publish-posts', 'guard_name' => 'web'],
            ['name' => 'manage-media', 'guard_name' => 'web'],
        ];

        $permissionModels = [];
        foreach ($permissions as $permission) {
            $permissionModels[$permission['name']] = Permission::findOrCreate(
                $permission['name'],
                $permission['guard_name']
            );
        }

        
        $adminRole = Role::findOrCreate('admin', 'web');
        $editorRole = Role::findOrCreate('editor', 'web');
        $authorRole = Role::findOrCreate('author', 'web');
        $guestRole = Role::findOrCreate('guest', 'web');

        
        
        $adminRole->syncPermissions(array_values($permissionModels));

        
        $editorRole->syncPermissions([
            'manage-categories',
            'manage-posts',
            'publish-posts',
            'manage-media',
            'manage-liturgies',
        ]);

        
        $authorRole->syncPermissions([
            'manage-media',
        ]);
    }
}
