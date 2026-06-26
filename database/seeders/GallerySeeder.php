<?php

namespace Database\Seeders;

use App\Models\GalleryPhoto;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Seed gallery photos: 5 restaurant/food + 8 staff (personal).
     */
    public function run(): void
    {
        // Clear existing photos so re-seeding doesn't duplicate
        GalleryPhoto::truncate();

        $photos = [
            // ── Restaurant / Food Photos ────────────────────────
            [
                'image_url'     => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1200&q=80',
                'category'      => 'galeria',
                'caption'       => 'Intérieur du restaurant MAREA',
                'display_order' => 1,
            ],
            [
                'image_url'     => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1200&q=80',
                'category'      => 'galeria',
                'caption'       => 'Plats vedettes de notre carte',
                'display_order' => 2,
            ],
            [
                'image_url'     => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1200&q=80',
                'category'      => 'galeria',
                'caption'       => 'Ambiance nocturne chez MAREA',
                'display_order' => 3,
            ],
            [
                'image_url'     => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1200&q=80',
                'category'      => 'galeria',
                'caption'       => 'Cuisine méditerranéenne à l\'âme marocaine',
                'display_order' => 4,
            ],
            [
                'image_url'     => 'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=1200&q=80',
                'category'      => 'galeria',
                'caption'       => 'Terrasse au coucher du soleil',
                'display_order' => 5,
            ],

            // ── Staff / Personal Photos ─────────────────────────
            [
                'image_url'     => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?w=800&q=80',
                'category'      => 'personal',
                'caption'       => 'Hassan — Chef Exécutif',
                'display_order' => 1,
            ],
            [
                'image_url'     => 'https://images.unsplash.com/photo-1581299894007-aaa50297cf16?w=800&q=80',
                'category'      => 'personal',
                'caption'       => 'Notre Équipe — Salle',
                'display_order' => 2,
            ],
            [
                'image_url'     => 'https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?w=800&q=80',
                'category'      => 'personal',
                'caption'       => 'Ahmed — Chef de Partie',
                'display_order' => 3,
            ],
        ];

        foreach ($photos as $photo) {
            GalleryPhoto::create($photo);
        }
    }
}
