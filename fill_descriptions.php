<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$descriptions = [
    'Petits-Déjeuners' => 'Commencez la journée du bon pied avec nos délicieux petits-déjeuners marocains et internationaux.',
    'Salades' => 'Des salades fraîches, croquantes et colorées pour une touche légère et saine.',
    'Entrées Chaudes' => 'Des entrées réconfortantes et savoureuses pour vous ouvrir l\'appétit.',
    'Cuisine Marocaine' => 'Plongez dans l\'authenticité des épices et des saveurs traditionnelles du Maroc.',
    'Poke Bowl' => 'Des bols hawaïens colorés, sains et généreusement garnis d\'ingrédients frais.',
    'Plats du Monde' => 'Un véritable voyage culinaire à travers les meilleures recettes internationales.'
];

foreach (App\Models\Category::all() as $cat) {
    if (isset($descriptions[$cat->name])) {
        $cat->description = $descriptions[$cat->name];
    } else {
        $cat->description = 'Découvrez notre sélection spéciale de ' . strtolower($cat->name) . ', préparée avec soin.';
    }
    $cat->save();
}
echo "Descriptions mises à jour !";
