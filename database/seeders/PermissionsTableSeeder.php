<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     // Define the list of permissions
     $permissions = [
        'list-channel', 'create-channel', 'edit-channel', 'delete-channel', 'update-status-channel',
        'list-country', 'create-country', 'update-country', 'delete-country',
        'list-language', 'create-language', 'update-language', 'delete-language',
        'list-notification', 'create-notification', 'update-notification', 'delete-notification',
        'list-permission', 'create-permission', 'update-permission', 'delete-permission',
        'list-post', 'create-post', 'update-post', 'delete-post',
        'list-role', 'create-role', 'edit-role', 'delete-role',
        'list-rssfeed', 'create-rssfeed', 'update-rssfeed', 'delete-rssfeed',
        'list-settings', 'create-settings', 'update-settings', 'delete-settings',
        'list-topic', 'create-topic', 'update-topic', 'delete-topic',
        'list-webtheme', 'create-webtheme', 'update-webtheme', 'delete-webtheme',
        'create-form-story','store-story','edit-form-story', 'update-story', 'delete-story'
    ];
    
    $permissionsData = [];
    foreach ($permissions as $permission) {
        $permissionsData[] = [
            'name' => $permission,
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

        // Insert permissions into the 'permissions' table
        DB::table('permissions')->insert($permissionsData);
    }
}
