<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'pemkabokut@admin.com',
            'unit' => 'Bidang Infrastruktur Teknologi Informasi',
            'is_verified' => true
        ]);
        User::factory()->create([
            'name' => 'Dwiponco Suripto',
            'email' => 'dwiponcosuripto01@gmail.com',
            'unit' => 'Bidang Informasi dan Komunikasi Publik'
        ]);

        $this->call([
            CategorySeeder::class,
            HeadlineSeeder::class,
            PostSeeder::class,
            DataSeeder::class,
            DocumentSeeder::class,
            IconSeeder::class,
            FileSeeder::class,
            DropdownSeeder::class
        ]);
    }
}
