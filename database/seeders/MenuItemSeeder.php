<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Seed 60+ realistic Mediterranean/Moroccan menu items with HD Unsplash photos.
     * Each image URL is hand-picked to match the dish category for a professional demo.
     */
    public function run(): void
    {
        $menuData = [

            // ─────────────────────────────────────────────────────
            // 1. PETITS-DÉJEUNERS
            // ─────────────────────────────────────────────────────
            'Petits-Déjeuners' => [
                [
                    'name'        => 'Petit-Déjeuner Méditerranéen',
                    'description' => 'Œufs brouillés aux tomates, olives, fromage feta, pain artisanal grillé et huile d\'olive vierge extra.',
                    'price'       => 9.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Petit-Déjeuner Marocain',
                    'description' => 'Msemen maison, miel de fleur d\'oranger, beurre de smen, confiture de figues et thé à la menthe.',
                    'price'       => 8.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1528207776546-365bb710ee93?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Toast à l\'Avocat',
                    'description' => 'Pain au levain avec avocat écrasé, œuf poché, graines de sésame et sumac.',
                    'price'       => 8.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1541519227354-08fa5d50c44d?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Açaí Bowl MAREA',
                    'description' => 'Açaí biologique avec granola maison, banane, fraises, noix de coco râpée et miel.',
                    'price'       => 10.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1590301157890-4810ed352733?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 2. SALADES
            // ─────────────────────────────────────────────────────
            'Salades' => [
                [
                    'name'        => 'Salade MAREA',
                    'description' => 'Mix de laitues, poulet grillé, avocat, tomates cerises, parmesan et vinaigrette au citron.',
                    'price'       => 12.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=800&q=80',
                    'is_featured' => true,
                ],
                [
                    'name'        => 'Salade Fattoush',
                    'description' => 'Salade libanaise avec pain pita croustillant, concombre, radis, menthe fraîche et vinaigrette à la grenade.',
                    'price'       => 11.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Taboulé Classique',
                    'description' => 'Boulgour, persil frais, tomate, oignon, menthe, citron et huile d\'olive.',
                    'price'       => 9.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1529059997568-3d847b1154f0?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 3. ENTRÉES CHAUDES
            // ─────────────────────────────────────────────────────
            'Entrées Chaudes' => [
                [
                    'name'        => 'Briouats au Poulet',
                    'description' => 'Triangles croustillants de pâte brick farcis de poulet épicé, amandes et cannelle.',
                    'price'       => 8.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Falafel avec Houmous',
                    'description' => 'Falafel maison de pois chiches croustillant, servi avec houmous crémeux et pain pita chaud.',
                    'price'       => 9.50,
                    'image_url'   => 'http://localhost:8000/images.php?name=falafel_with_hummus_1781641273358.png',
                    'is_featured' => true,
                ],
                [
                    'name'        => 'Crevettes à l\'Ail',
                    'description' => 'Crevettes sautées à l\'huile d\'olive avec ail émincé, piment et persil frais.',
                    'price'       => 13.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Patatas Bravas MAREA',
                    'description' => 'Pommes de terre croustillantes avec sauce piquante et aïoli à la harissa maison.',
                    'price'       => 7.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1585672840563-f2af2ced55c9?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 4. CUISINE MAROCAINE
            // ─────────────────────────────────────────────────────
            'Cuisine Marocaine' => [
                [
                    'name'        => 'Tajine d\'Agneau',
                    'description' => 'Agneau mijoté lentement avec pruneaux, amandes grillées, cannelle et miel de fleur d\'oranger.',
                    'price'       => 18.90,
                    'image_url'   => 'http://localhost:8000/images.php?name=lamb_tagine_1781641329105.png',
                    'is_featured' => true,
                ],
                [
                    'name'        => 'Couscous Royal',
                    'description' => 'Couscous cuit à la vapeur avec sept légumes, pois chiches, agneau et bouillon parfumé au ras el hanout.',
                    'price'       => 16.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=800&q=80',
                    'is_featured' => true,
                ],
                [
                    'name'        => 'Pastilla au Poulet',
                    'description' => 'Feuilleté croustillant farci de poulet épicé, amandes et œuf, saupoudré de cannelle et sucre glace.',
                    'price'       => 15.90,
                    'image_url'   => 'http://localhost:8000/images.php?name=chicken_pastilla_1781641423449.png',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Kefta à l\'Œuf',
                    'description' => 'Boulettes de bœuf épicées en sauce tomate avec œufs pochés et pain marocain.',
                    'price'       => 14.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1574484284002-952d92456975?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Harira',
                    'description' => 'Soupe traditionnelle de lentilles, pois chiches, tomate et coriandre avec une touche de citron.',
                    'price'       => 7.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 5. POKE BOWL
            // ─────────────────────────────────────────────────────
            'Poke Bowl' => [
                [
                    'name'        => 'Poke Saumon',
                    'description' => 'Riz à sushi, saumon frais mariné, avocat, edamame, mangue, algue wakame et sauce ponzu.',
                    'price'       => 14.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800&q=80',
                    'is_featured' => true,
                ],
                [
                    'name'        => 'Poke Thon',
                    'description' => 'Riz à sushi, thon rouge, concombre, carotte marinée, sésame et sauce sriracha-mayo.',
                    'price'       => 15.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Poke Végane',
                    'description' => 'Quinoa, tofu mariné, avocat, mangue, edamame, radis et vinaigrette au gingembre.',
                    'price'       => 13.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 6. PLATS DU MONDE
            // ─────────────────────────────────────────────────────
            'Plats du Monde' => [
                [
                    'name'        => 'Poulet Tikka Masala',
                    'description' => 'Blanc de poulet mariné au yaourt et aux épices, cuisiné en sauce crémeuse de tomate et garam masala.',
                    'price'       => 15.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Pad Thaï',
                    'description' => 'Nouilles de riz sautées au wok avec crevettes, œuf, cacahuètes, germes de soja et sauce tamarind.',
                    'price'       => 14.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1559314809-0d155014e29e?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Gyoza au Porc',
                    'description' => 'Raviolis japonais à la poêle farcis de porc et gingembre, avec sauce soja et vinaigre de riz.',
                    'price'       => 10.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 7. PÂTES
            // ─────────────────────────────────────────────────────
            'Pâtes' => [
                [
                    'name'        => 'Linguini alle Vongole',
                    'description' => 'Linguini avec palourdes fraîches, ail, vin blanc, persil et une touche de piment.',
                    'price'       => 16.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Rigatoni al Ragù',
                    'description' => 'Rigatoni avec ragù napolitain de bœuf cuisiné à feu doux pendant 6 heures.',
                    'price'       => 14.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Penne al Pesto',
                    'description' => 'Penne rigate avec pesto génois au basilic frais, pignons, parmigiano reggiano et huile d\'olive.',
                    'price'       => 13.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1473093295043-cdd812d0e601?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 8. WRAPS
            // ─────────────────────────────────────────────────────
            'Wraps' => [
                [
                    'name'        => 'Wrap Shawarma',
                    'description' => 'Tortilla de blé avec poulet shawarma, laitue, tomate, oignon rouge et sauce tahini.',
                    'price'       => 10.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Wrap Falafel',
                    'description' => 'Falafel croustillant, houmous, concombre, tomate, pickles et sauce yaourt en pain plat.',
                    'price'       => 9.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Wrap César',
                    'description' => 'Poulet grillé, laitue romaine, parmesan, croûtons croustillants et sauce César maison.',
                    'price'       => 10.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 9. TACOS GRATINÉS
            // ─────────────────────────────────────────────────────
            'Tacos Gratinés' => [
                [
                    'name'        => 'Taco Pulled Pork',
                    'description' => 'Tortilla de maïs avec porc effiloché BBQ, cheddar gratiné et coleslaw.',
                    'price'       => 11.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Taco Poulet Tikka',
                    'description' => 'Tortilla avec poulet tikka, mozzarella fondue, oignon caramélisé et coriandre.',
                    'price'       => 11.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Taco Végétal',
                    'description' => 'Légumes rôtis, fromage de chèvre gratiné, roquette, noix et réduction au miel.',
                    'price'       => 10.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1599974579688-8dbdd335c77f?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 10. BURGERS
            // ─────────────────────────────────────────────────────
            'Burgers' => [
                [
                    'name'        => 'Burger MAREA',
                    'description' => 'Double smash burger de bœuf, cheddar fumé, oignon caramélisé, bacon croustillant et sauce secrète.',
                    'price'       => 14.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&q=80',
                    'is_featured' => true,
                ],
                [
                    'name'        => 'Burger d\'Agneau',
                    'description' => 'Burger d\'agneau épicé avec feta, concombre mariné, roquette et sauce yaourt à la menthe.',
                    'price'       => 15.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Burger Végane',
                    'description' => 'Burger de betterave et quinoa, avocat, laitue, tomate et mayonnaise végane au chipotle.',
                    'price'       => 13.90,
                    'image_url'   => 'http://localhost:8000/images.php?name=vegan_burger_1781641447265.png',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 11. PIZZAS
            // ─────────────────────────────────────────────────────
            'Pizzas' => [
                [
                    'name'        => 'Pizza Méditerranéenne',
                    'description' => 'Tomate San Marzano, mozzarella, olives kalamata, artichauts, poivron rôti et origan frais.',
                    'price'       => 14.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Pizza Merguez',
                    'description' => 'Base tomate, mozzarella, merguez piquant, oignon rouge, poivron vert et harissa.',
                    'price'       => 15.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Pizza à la Truffe',
                    'description' => 'Crème de truffe, mozzarella di bufala, champignons portobello, roquette et copeaux de parmesan.',
                    'price'       => 17.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 12. POISSON ET VIANDE AU KILO
            // ─────────────────────────────────────────────────────
            'Poisson et Viande au Kilo' => [
                [
                    'name'        => 'Bar Grillé',
                    'description' => 'Bar frais du jour cuit à la braise avec herbes méditerranéennes, citron et huile d\'olive. Prix au kilo.',
                    'price'       => 24.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1534604973900-c43ab4c2e0ab?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Côte de Bœuf',
                    'description' => 'Côte de bœuf maturée 45 jours, cuite à la braise. Prix au kilo.',
                    'price'       => 25.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1558030006-450675393462?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Crevettes Rouges',
                    'description' => 'Crevettes rouges de Méditerranée grillées avec gros sel et citron. Prix au kilo.',
                    'price'       => 22.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1625943553852-781c6dd46faa?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 13. DESSERTS
            // ─────────────────────────────────────────────────────
            'Desserts' => [
                [
                    'name'        => 'Baklava à la Pistache',
                    'description' => 'Feuilleté croustillant de fines couches avec pistaches concassées, imbibé de sirop de fleur d\'oranger.',
                    'price'       => 7.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1519676867240-f03562e64548?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Crème Brûlée',
                    'description' => 'Crème à la vanille de Madagascar avec croûte de caramel croustillante.',
                    'price'       => 7.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Pastilla au Lait',
                    'description' => 'Dessert marocain : feuilleté croustillant fourré de crème au lait et amandes, avec cannelle.',
                    'price'       => 6.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Tarte au Chocolat',
                    'description' => 'Tarte au chocolat noir 70% avec fond de biscuit et coulis de framboise.',
                    'price'       => 8.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 14. CAFÉS
            // ─────────────────────────────────────────────────────
            'Cafés' => [
                [
                    'name'        => 'Espresso',
                    'description' => 'Double espresso italien avec crème naturelle.',
                    'price'       => 2.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Café aux Épices',
                    'description' => 'Café arabica avec cannelle, cardamome et une touche de muscade. Servi avec lait mousseux.',
                    'price'       => 4.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Thé à la Menthe',
                    'description' => 'Thé vert gunpowder avec menthe fraîche et sucre, servi dans un verre traditionnel.',
                    'price'       => 3.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 15. JUS
            // ─────────────────────────────────────────────────────
            'Jus' => [
                [
                    'name'        => 'Jus d\'Orange Frais',
                    'description' => 'Jus d\'oranges fraîchement pressées.',
                    'price'       => 4.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Jus Détox Vert',
                    'description' => 'Épinards, concombre, pomme verte, gingembre et citron.',
                    'price'       => 5.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1610970881699-44a5587cabec?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Jus Tropical',
                    'description' => 'Mangue, ananas, fruit de la passion et orange naturelle.',
                    'price'       => 5.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 16. MOJITOS
            // ─────────────────────────────────────────────────────
            'Mojitos' => [
                [
                    'name'        => 'Mojito Classique',
                    'description' => 'Rhum blanc, menthe fraîche, citron vert, sucre de canne et soda.',
                    'price'       => 8.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1551538827-9c037cb4f32a?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Mojito à la Mangue',
                    'description' => 'Rhum blanc, purée de mangue fraîche, menthe, citron vert et soda.',
                    'price'       => 9.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Mojito à la Fraise',
                    'description' => 'Rhum blanc, fraises fraîches écrasées, menthe, citron vert et soda.',
                    'price'       => 9.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 17. MILKSHAKES
            // ─────────────────────────────────────────────────────
            'Milkshakes' => [
                [
                    'name'        => 'Milkshake Chocolat',
                    'description' => 'Glace au chocolat belge, lait, chantilly et copeaux de chocolat.',
                    'price'       => 6.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Milkshake Vanille',
                    'description' => 'Glace à la vanille de Madagascar, lait, chantilly et caramel.',
                    'price'       => 6.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Milkshake Oreo',
                    'description' => 'Glace vanille, biscuits Oreo émiettés, lait, chantilly et sirop de chocolat.',
                    'price'       => 7.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1568901839119-631418a3910d?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 18. BOISSONS
            // ─────────────────────────────────────────────────────
            'Boissons' => [
                [
                    'name'        => 'Eau Minérale',
                    'description' => 'Eau minérale naturelle 500ml.',
                    'price'       => 2.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Coca-Cola',
                    'description' => 'Coca-Cola original 330ml.',
                    'price'       => 3.00,
                    'image_url'   => 'https://images.unsplash.com/photo-1554866585-cd94860890b7?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Limonade Maison',
                    'description' => 'Limonade naturelle à la menthe, gingembre et miel.',
                    'price'       => 4.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1621263764928-df1444c5e859?w=800&q=80',
                    'is_featured' => false,
                ],
            ],

            // ─────────────────────────────────────────────────────
            // 19. COCKTAILS
            // ─────────────────────────────────────────────────────
            'Cocktails' => [
                [
                    'name'        => 'Margarita MAREA',
                    'description' => 'Tequila reposado, triple sec, jus de citron vert frais et sel de flocon au paprika fumé.',
                    'price'       => 10.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1556855810-ac404aa91e85?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Gin Tonic Méditerranéen',
                    'description' => 'Gin premium, tonic artisanal, romarin, concombre et baies de genévrier.',
                    'price'       => 11.50,
                    'image_url'   => 'https://images.unsplash.com/photo-1560512823-829485b8bf24?w=800&q=80',
                    'is_featured' => false,
                ],
                [
                    'name'        => 'Aperol Spritz',
                    'description' => 'Aperol, prosecco, soda et rondelle d\'orange.',
                    'price'       => 9.90,
                    'image_url'   => 'https://images.unsplash.com/photo-1560512823-829485b8bf24?w=800&q=80',
                    'is_featured' => false,
                ],
            ],
        ];

        foreach ($menuData as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->first();

            if (!$category) {
                continue;
            }

            foreach ($items as $index => $itemData) {
                MenuItem::create([
                    'category_id'    => $category->id,
                    'name'           => $itemData['name'],
                    'description'    => $itemData['description'],
                    'price'          => $itemData['price'],
                    'rating'         => rand(40, 49) / 10,
                    'image_url'      => $itemData['image_url'],
                    'display_number' => $index + 1,
                    'is_available'   => true,
                    'is_featured'    => $itemData['is_featured'],
                ]);
            }
        }
    }
}
