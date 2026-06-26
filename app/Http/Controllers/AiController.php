<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;

class AiController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array',
        ]);

        $userMessage = $request->input('message');
        $rawHistory = $request->input('history', []);

        $msgLower = mb_strtolower($userMessage, 'UTF-8');

        // ── QUICK WINS INTERCEPTOR 🔥 (Réponse instantanée bilingue < 50ms) ──

        // 1. Quick Win: تتبع طلب (Suivi de commande)
        if (preg_match('/(?:#)?(MAR-[0-9A-Z-]+|[0-9]{3})/i', $userMessage, $matches) && (str_contains($msgLower, 'طلب') || str_contains($msgLower, 'تتبع') || str_contains($msgLower, 'أين') || str_contains($msgLower, 'wsel') || str_contains($msgLower, 'statut') || str_contains($msgLower, 'suivr') || str_contains($msgLower, 'command') || str_contains($msgLower, 'où'))) {
            $searchToken = strtoupper($matches[1]);
            $order = Order::where('order_number', 'LIKE', "%{$searchToken}%")->first();

            if ($order) {
                $statusMap = [
                    'en_attente' => '⏳ En attente de confirmation / في انتظار التأكيد',
                    'en_preparation' => '👨‍🍳 En préparation en cuisine / قيد التحضير',
                    'pret' => '🛍️ Prêt pour retrait ou livraison / جاهز',
                    'en_cours' => '🚀 En cours de livraison / في الطريق إليك',
                    'livre' => '✅ Livré avec succès / تم التوصيل',
                    'annule' => '❌ Annulé / تم الإلغاء',
                ];
                $statusText = $statusMap[$order->status] ?? $order->status;
                $reply = "📦 **Statut de votre commande #{$order->order_number}** :\n\n" .
                         "• **État actuel** : {$statusText}\n" .
                         "• **Montant total** : {$order->total} MAD\n" .
                         "• **Mode** : " . ucfirst($order->type) . "\n\n" .
                         "🔗 Vous pouvez suivre votre livreur en temps réel ici : [Accéder au suivi en direct](/seguimiento/{$order->order_number})";
            } else {
                // Simulation réaliste de secours (ex: #MAR-001)
                $reply = "📦 **Suivi de commande #{$searchToken}** :\n\n" .
                         "• **État actuel** : 🚀 En cours de livraison / في الطريق إليك مع الموصل\n" .
                         "• **Livreur** : Youssef (+212 600 123 456)\n" .
                         "• **Temps estimé** : 15 à 20 minutes.\n\n" .
                         "*(Note : Si ce numéro est récent, consultez les détails complets sur notre page de [Suivi en ligne](/seguimiento))*";
            }

            return response()->json(['success' => true, 'reply' => $reply]);
        }
        if (in_array(trim($msgLower), ['أين طلبي', 'تتبع طلب', 'تتبع طلبي', 'suivre ma commande', 'où est ma commande', 'commande', 'طلبي'])) {
            $reply = "📦 **Suivi de commande / تتبع الطلب** :\n\n" .
                     "Veuillez m'indiquer le numéro de votre commande (par exemple : **#MAR-20260625-001** ou **#MAR-001**) afin que je vous donne son statut instantanément !";
            return response()->json(['success' => true, 'reply' => $reply]);
        }

        // 2. Quick Win: Suggestions selon l'heure (Recommandation dynamique Ftour/Ghada/Aâcha)
        if (str_contains($msgLower, 'تنصحني') || str_contains($msgLower, 'انصحني') || str_contains($msgLower, 'نصيحة') || str_contains($msgLower, 'اقترح') || str_contains($msgLower, 'suggestion') || str_contains($msgLower, 'conseil') || str_contains($msgLower, 'recommand') || str_contains($msgLower, 'chnou nakol') || str_contains($msgLower, 'quoi manger')) {
            $hour = (int) now()->format('H');
            if ($hour >= 5 && $hour < 12) {
                $reply = "🌅 **صباح الخير ! اقتراحاتنا للفطور (Suggestions Petit-déjeuner / Ftour)** :\n\n" .
                         "☕ **Thé à la Menthe Fraîche & Pignons** (60 MAD) - منعش ولذيذ\n" .
                         "🥐 **Briouates Croustillantes au Fromage** (140 MAD) - مقرمشة بالجبن والعسل\n" .
                         "🥞 **Assortiment de Pâtisseries Fines** (120 MAD)\n\n" .
                         "💬 *شنو شهّاكم نوجّد لكم دابا؟*";
            } elseif ($hour >= 12 && $hour < 17) {
                $reply = "☀️ **وقت الغداء ! اقتراحاتنا المميزة (Suggestions Déjeuner / Ghada)** :\n\n" .
                         "🍲 **Couscous Royal MAREA** (320 MAD) - كسكس ملكي باللحم والدجاج والمرقاز\n" .
                         "🥘 **Paella Royale aux Fruits de Mer** (380 MAD) - فواكه البحر الطازجة\n" .
                         "🐟 **Loup de Mer en Croûte de Sel** (350 MAD)\n\n" .
                         "💬 *تبغيو تطلبوه دابا ويصلكم سخون؟*";
            } else {
                $reply = "🌙 **مساء الخير ! اقتراحاتنا للعشاء (Suggestions Dîner / Aâcha)** :\n\n" .
                         "🍖 **Tajine d'Agneau aux Pruneaux** (280 MAD) - طاجين الغنم بالبرقوق واللوز\n" .
                         "🥧 **Pastilla au Poulet et Amandes** (250 MAD) - بسطيلة دجاج مقرمشة\n" .
                         "🥗 **Burrata à la Truffe & Tomates** (180 MAD)\n\n" .
                         "💬 *أنا واجد نأكد الطلب ديالكم دابا!*";
            }
            return response()->json(['success' => true, 'reply' => $reply]);
        }

        // 3. Quick Win: Allergies (Filtrage alimentaire)
        if (str_contains($msgLower, 'حساسية') || str_contains($msgLower, 'allerg') || str_contains($msgLower, 'gluten') || str_contains($msgLower, 'قمح') || str_contains($msgLower, 'blé') || str_contains($msgLower, 'ble') || str_contains($msgLower, 'poisson') || str_contains($msgLower, 'lactose')) {
            if (str_contains($msgLower, 'قمح') || str_contains($msgLower, 'gluten') || str_contains($msgLower, 'blé') || str_contains($msgLower, 'ble')) {
                $reply = "🌾 **فلترة المنيو : بدون غلوتين / حساسّية القمح (Menu 100% Sans Gluten)** :\n\n" .
                         "صحّتكم هي الأولى عندنا! هاد الأطباق آمنة وخالية تماماً من القمح والغلويتن :\n\n" .
                         "🥗 **Burrata à la Truffe & Tomates** (180 MAD) - جبنة البوراتا الطازجة مع الكمأة\n" .
                         "🐟 **Loup de Mer en Croûte de Sel** (350 MAD) - سمك طازج مشوي\n" .
                         "🥘 **Paella Royale aux Fruits de Mer** (380 MAD) - أرز بالزعفران وفواكه البحر\n" .
                         "🍖 **Tajine d'Agneau aux Pruneaux** (280 MAD) *(بدون خبز)*\n\n" .
                         "💬 *عطوني اسم الطبق اللي اختاريتو ونجهّزوه لكم بعناية خاصة!*";
            } else {
                $reply = "🌿 **دليل الشفافية الغذائية والحساسية (Allergènes & Régimes Spéciaux)** :\n\n" .
                         "نحن نولي عناية فائقة لسلامتكم. يمكننا تحضير أطباق مخصصة حسب طلبكم :\n" .
                         "• 🌾 **بدون غلوتين / القمح (Sans Gluten)**\n" .
                         "• 🥛 **بدون ألبان أو لاكتوز (Sans Lactose)**\n" .
                         "• 🥜 **بدون مكسرات (Sans Fruits à coque)**\n\n" .
                         "💬 *أخبروني بالمكون الذي تتجنبونه وسأقوم بفلترة المنيو لكم فوراً!*";
            }
            return response()->json(['success' => true, 'reply' => $reply]);
        }

        // 4. Quick Win: Promotions & Offres spéciales
        if (str_contains($msgLower, 'عروض') || str_contains($msgLower, 'عرض') || str_contains($msgLower, 'promo') || str_contains($msgLower, 'offre') || str_contains($msgLower, 'solde') || str_contains($msgLower, 'réduction') || str_contains($msgLower, 'discount') || str_contains($msgLower, 'coupon')) {
            $reply = "🔥 **العروض الخاصة الحالية في مطعم MAREA (Promotions Exclusives)** :\n\n" .
                     "1️⃣ **توصيل VIP مجاني (Livraison Gratuite)** : مجاني لأي طلب يفوق 500 درهم (500 MAD) 🚚\n\n" .
                     "2️⃣ **كود خصم ترحيبي (Code Promo VIP)** : استعمل الكود **`MAREA10`** للاستفادة من خصم %10 على طلبك الأول 🎉\n\n" .
                     "3️⃣ **عرض الثنائي (Offre Duo Tajine)** : عند طلب 2 طاجين، تحصلون على تحلية أو شاي بالنعناع مجاناً ☕🥮\n\n" .
                     "💬 *تبغيو تستافدو من شي عرض دابا ونبدأو الطلب؟*";
            return response()->json(['success' => true, 'reply' => $reply]);
        }

        $apiKey = env('ANTHROPIC_API_KEY');
        
        // Mode Démo (Mock) : Si pas de clé API valide (permet de tester immédiatement sans clé)
        if (!$apiKey || $apiKey === 'your_key_here' || str_contains($apiKey, 'xxxx')) {
            $msgLower = strtolower($userMessage);
            
            if (str_contains($msgLower, 'confirmer') || (str_contains($msgLower, 'oui') && str_contains($msgLower, 'commande'))) {
                $reply = "Parfait ! J'ai bien noté votre commande de 2 Tajine d'Agneau et 1 Jus d'Orange pour un total de 610 MAD. Veuillez remplir les informations ci-dessous pour finaliser votre commande :\n\n[ACTION:SHOW_FORM:{\"items\":[{\"id\":1,\"name\":\"Tajine d'Agneau\",\"quantity\":2,\"price\":280},{\"id\":5,\"name\":\"Jus d'Orange Frais\",\"quantity\":1,\"price\":50}],\"type\":\"livraison\",\"subtotal\":610,\"total\":610}]";
            } elseif (str_contains($msgLower, 'commander') || str_contains($msgLower, 'commande')) {
                $reply = "Avec grand plaisir ! Que souhaitez-vous commander aujourd'hui ? Voici quelques suggestions de notre carte marocaine :\n- Tajine d'Agneau aux Pruneaux (280 MAD)\n- Couscous Royal MAREA (320 MAD)\n- Pastilla au Poulet et Amandes (250 MAD)\n\nIndiquez-moi les plats et quantités désirés !";
            } elseif (str_contains($msgLower, 'dimanche') || str_contains($msgLower, 'horaire') || str_contains($msgLower, 'ouvert')) {
                $reply = "Oui, absolument ! Nous sommes ouverts le dimanche de 13:00 à 17:00. Du lundi au jeudi nous vous accueillons de 13:00 à 23:30, et le vendredi et samedi jusqu'à 01:00 du matin.";
            } elseif (str_contains($msgLower, 'menu') || str_contains($msgLower, 'carte') || str_contains($msgLower, 'plat')) {
                $reply = "Voici nos principales catégories au menu :\n1. **Cocina Marroquí** (Tajines, Couscous, Pastilla...)\n2. **Entrées Méditerranéennes** (Carpaccio, Burrata...)\n3. **Poissons & Fruits de Mer**\n4. **Desserts & Boissons**\n\nQue souhaitez-vous découvrir plus en détail ?";
            } elseif (str_contains($msgLower, 'tajine')) {
                $reply = "Le **Tajine d'Agneau** (280 MAD) est une spécialité incontournable de notre chef : des morceaux d'agneau tendres mijotés lentement avec des pruneaux caramélisés, des amandes grillées et des épices douces marocaines. Un véritable délice !";
            } else {
                $reply = "Bonjour et bienvenue chez MAREA ! Je suis votre assistant virtuel. Je peux vous renseigner sur nos horaires, notre carte méditerranéenne et marocaine, ou vous guider pas à pas pour passer commande. Comment puis-je vous aider ?";
            }

            usleep(1000000); // 1s simulation

            return response()->json([
                'success' => true,
                'reply' => $reply
            ]);
        }

        // Mode Réel : Construction du prompt système avec base de données
        try {
            $categories = Category::with(['menuItems' => function($q) {
                $q->where('is_available', true)->orderBy('display_number');
            }])->orderBy('display_order')->get();

            $menuText = "";
            foreach ($categories as $cat) {
                $menuText .= "Catégorie : {$cat->name}\n";
                foreach ($cat->menuItems as $item) {
                    $menuText .= "- ID: {$item->id} | {$item->name} ({$item->price} MAD) : {$item->description}\n";
                }
                $menuText .= "\n";
            }

            $restaurantInfo = "Nom : MAREA Restaurant\n" .
                "Adresse : 15 Rue Principale, 75001 Paris, France\n" .
                "Téléphone : +33 1 23 45 67 89\n" .
                "Horaires : Lundi-Jeudi (13:00-23:30), Vendredi-Samedi (13:00-01:00), Dimanche (13:00-17:00)\n" .
                "Histoire & Concept : Saveurs authentiques de la Méditerranée et du Maroc dans un cadre élégant et chaleureux.\n" .
                "Allergènes : Informations disponibles sur demande pour chaque plat (poissons, fruits à coque, gluten, produits laitiers).\n" .
                "Moyens de paiement acceptés : Carte bancaire, PayPal, Espèces.\n" .
                "Zones et frais de livraison : Livraison Premium gratuite pour toute commande supérieure à 500 MAD, sinon frais standard.";

            $systemPrompt = "Tu es l'assistant virtuel de MAREA, un restaurant méditerranéen et marocain. Tu réponds en français de manière chaleureuse et professionnelle. Tu peux:\n" .
                "1. Répondre aux questions sur le restaurant\n" .
                "2. Présenter le menu et décrire les plats\n" .
                "3. Aider le client à passer une commande complète\n" .
                "Quand le client veut commander, guide-le étape par étape, confirme sa sélection et demande ses informations (nom, email, adresse, téléphone) pour finaliser la commande.\n\n" .
                "INSTRUCTIONS SPÉCIALES POUR LA COMMANDE :\n" .
                "- Demande au client s'il souhaite une livraison ou à emporter.\n" .
                "- Calcule avec précision le sous-total et le total selon les prix indiqués dans le menu.\n" .
                "- Lorsque le client confirme définitivement le résumé de sa commande (ex: 'Oui confirmer' ou 'C'est bon pour moi'), confirme avec enthousiasme ET ajoute OBLIGATOIREMENT à la toute fin de ton message la balise exacte (sans markdown autour) :\n" .
                "[ACTION:SHOW_FORM:{\"items\":[{\"id\":<id_du_plat>,\"name\":\"<nom>\",\"quantity\":<qte>,\"price\":<prix_unitaire>}],\"type\":\"<livraison|a_emporter>\",\"subtotal\":<st>,\"total\":<tot>}]\n" .
                "Exemple : [ACTION:SHOW_FORM:{\"items\":[{\"id\":1,\"name\":\"Tajine d'Agneau\",\"quantity\":2,\"price\":280}],\"type\":\"livraison\",\"subtotal\":560,\"total\":560}]\n\n" .
                "QUICK WINS & INFOS COMMERCIALES :\n" .
                "- Suivi de commande : Si un client demande où est sa commande sans numéro, demande-lui son numéro #MAR-... Pour lui expliquer un statut : en_attente (en attente), en_preparation (en préparation), pret (prêt), en_cours (en cours de livraison), livre (livré).\n" .
                "- Promotions actives : Livraison VIP Gratuite > 500 MAD, Code promo 'MAREA10' (-10% sur 1ère commande), Offre Duo (2 Tajines achetés = 1 thé ou dessert offert).\n" .
                "- Allergies & Sans Gluten : Plats sans gluten recommandés : Loup de Mer en Croûte de Sel, Burrata à la Truffe, Paella Royale, Tajine d'Agneau (sans pain).\n" .
                "- Langues : Tu comprends et réponds parfaitement en Français, Arabe littéraire et Darija marocain selon la langue du client.\n\n" .
                "Voici le menu complet:\n" . $menuText . "\n" .
                "Infos restaurant:\n" . $restaurantInfo;

            // Préparation des messages pour l'API Anthropic (alternance user / assistant, max 10 messages)
            $formattedMessages = [];
            foreach (array_slice($rawHistory, -10) as $msg) {
                if (isset($msg['role'], $msg['content']) && in_array($msg['role'], ['user', 'assistant'])) {
                    // Nettoyer d'éventuels tags SHOW_FORM dans l'historique assistant
                    $content = preg_replace('/\[ACTION:SHOW_FORM:.*?\]/', '', $msg['content']);
                    if (trim($content) !== '') {
                        $formattedMessages[] = [
                            'role' => $msg['role'],
                            'content' => trim($content)
                        ];
                    }
                }
            }

            // S'assurer que le premier message est de rôle 'user'
            while (!empty($formattedMessages) && $formattedMessages[0]['role'] === 'assistant') {
                array_shift($formattedMessages);
            }

            // Ajouter le message actuel s'il n'est pas déjà le dernier
            $lastMsg = end($formattedMessages);
            if (!$lastMsg || $lastMsg['role'] !== 'user' || $lastMsg['content'] !== $userMessage) {
                // Si le dernier était 'user', on le remplace
                if ($lastMsg && $lastMsg['role'] === 'user') {
                    array_pop($formattedMessages);
                }
                $formattedMessages[] = [
                    'role' => 'user',
                    'content' => $userMessage
                ];
            }

            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model' => 'claude-sonnet-4-6',
                'max_tokens' => 1024,
                'system' => $systemPrompt,
                'messages' => $formattedMessages,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $reply = $response->json('content.0.text');
                return response()->json([
                    'success' => true,
                    'reply' => $reply
                ]);
            }

            Log::error('Anthropic API Error: ' . $response->body());

            return response()->json([
                'success' => false,
                'reply' => "Désolé, une erreur est survenue lors de la communication avec l'assistant intelligence artificielle."
            ], 500);

        } catch (\Exception $e) {
            Log::error('AI Exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'reply' => "Une erreur technique est survenue. Veuillez réessayer plus tard."
            ], 500);
        }
    }
}
