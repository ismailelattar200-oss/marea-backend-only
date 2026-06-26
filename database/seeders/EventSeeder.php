<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Seed 6 upcoming events at MAREA.
     */
    public function run(): void
    {
        $events = [
            [
                'title'       => 'Nuit du Couscous',
                'description' => 'Dégustez un authentique couscous royal marocain préparé par le Chef Hassan, accompagné de musique andalouse en direct et de thé à la menthe. Un voyage sensoriel au cœur du Maroc.',
                'image_url'   => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=1200&q=80',
                'event_date'  => Carbon::now()->addDays(7)->setHour(20)->setMinute(30),
                'capacity'    => 40,
                'is_active'   => true,
            ],
            [
                'title'       => 'Dégustation Vins de la Méditerranée',
                'description' => 'Dégustation de 5 vins sélectionnés de la Méditerranée accompagnés de tapas exclusives de notre menu. Animée par le sommelier invité Pablo Merino.',
                'image_url'   => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=1200&q=80',
                'event_date'  => Carbon::now()->addDays(14)->setHour(19)->setMinute(0),
                'capacity'    => 25,
                'is_active'   => true,
            ],
            [
                'title'       => 'Brunch Dominical MAREA',
                'description' => 'Notre brunch le plus complet : stations de petits-déjeuners méditerranéens et marocains, jus frais, cocktails et musique chill. Réservation indispensable.',
                'image_url'   => 'https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?w=1200&q=80',
                'event_date'  => Carbon::now()->nextWeekendDay()->setHour(11)->setMinute(0),
                'capacity'    => 60,
                'is_active'   => true,
            ],
            [
                'title'       => 'Cours de Cuisine Marocaine',
                'description' => 'Apprenez à cuisiner un tajine, une pastilla et une harira avec le Chef Hassan. Comprend la dégustation de tout ce qui a été préparé et un livre de recettes numérique.',
                'image_url'   => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=1200&q=80',
                'event_date'  => Carbon::now()->addDays(21)->setHour(17)->setMinute(0),
                'capacity'    => 15,
                'is_active'   => true,
            ],
            [
                'title'       => 'Musique Live : Flamenco & Gnawa',
                'description' => 'Une fusion unique de flamenco et de musique gnawa en direct. Profitez d\'un menu spécial conçu pour la soirée.',
                'image_url'   => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=1200&q=80',
                'event_date'  => Carbon::now()->addDays(10)->setHour(21)->setMinute(0),
                'capacity'    => 50,
                'is_active'   => true,
            ],
            [
                'title'       => 'Dîner de la Saint-Jean',
                'description' => 'Menu dégustation spécial de 7 plats pour célébrer la Nuit de la Saint-Jean, avec terrasse ouverte et cocktails exclusifs.',
                'image_url'   => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=1200&q=80',
                'event_date'  => Carbon::now()->addDays(30)->setHour(21)->setMinute(30),
                'capacity'    => 45,
                'is_active'   => true,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
