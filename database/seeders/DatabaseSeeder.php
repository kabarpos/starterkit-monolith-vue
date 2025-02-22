<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class, // Jalankan ini dulu untuk membuat role
            SuperAdminSeeder::class, // Kemudian buat super admin
            SettingsSeeder::class,
        ]);
    }
}