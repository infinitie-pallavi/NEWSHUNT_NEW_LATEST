<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class InstallationSeeder extends Seeder {
    public function run() {

        Role::updateOrCreate(['name' => 'User']);
        Role::updateOrCreate(['name' => 'Admin']);

        $user = User::updateOrCreate(['id' => 1], [
            'id'       => 1,
            'name'     => 'admin',
            'email' => 'admin@gmail.com',
            'type'    => 'email',
            'password' => Hash::make('admin123'),
        ]);
        $user->syncRoles('Admin');
        Language::updateOrInsert(
            ['id' => 1],
            [
                'name'       => 'English',
                'code'       => 'en',
                'app_file'   => 'en.json',
                'panel_file' => 'en.json',
                'image'      => 'language/en.svg'
            ]
        );
        Setting::upsert(config('constants.DEFAULT_SETTINGS'), ['name'], ['value', 'type']);
    }
}
