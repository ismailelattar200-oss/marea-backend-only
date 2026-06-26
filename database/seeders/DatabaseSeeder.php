<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the entire MAREA database.
     * Order matters: Users → Categories → MenuItems → Orders → Gallery → Events → Jobs → Contacts.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            MenuItemSeeder::class,
            OrderSeeder::class,
            GallerySeeder::class,
            EventSeeder::class,
            JobApplicationSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
