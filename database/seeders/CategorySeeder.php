<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed the 19 menu categories in exact display order.
     */
    public function run(): void
    {
        $categories = [
            'Petits-Déjeuners',
            'Salades',
            'Entrées Chaudes',
            'Cuisine Marocaine',
            'Poke Bowl',
            'Plats du Monde',
            'Pâtes',
            'Wraps',
            'Tacos Gratinés',
            'Burgers',
            'Pizzas',
            'Poisson et Viande au Kilo',
            'Desserts',
            'Cafés',
            'Jus',
            'Mojitos',
            'Milkshakes',
            'Boissons',
            'Cocktails',
        ];

        foreach ($categories as $index => $name) {
            Category::create([
                'name'          => $name,
                'slug'          => Str::slug($name),
                'display_order' => $index + 1,
                'is_active'     => true,
            ]);
        }
    }
}
