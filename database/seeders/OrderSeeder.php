<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Seed 10 sample orders across all statuses, including assigned deliveries.
     */
    public function run(): void
    {
        $menuItems = MenuItem::all();
        $deliveryUsers = User::where('role', 'delivery')->get();
        $customers = User::where('role', 'customer')->get();

        $orders = [
            [
                'customer_name'  => 'Ana García',
                'customer_phone' => '+34 612 100 001',
                'customer_email' => 'ana@gmail.com',
                'customer_address' => 'Calle Gran Vía 25, Madrid',
                'status'         => 'livre',
                'type'           => 'livraison',
                'pickup_time'    => null,
                'notes'          => 'Sans piment s\'il vous plaît',
                'user_id'        => $customers[0]->id ?? null,
                'item_count'     => 3,
                'created_offset' => -15, // 15 mins ago
            ],
            [
                'customer_name'  => 'Javier Martín',
                'customer_phone' => '+34 612 100 002',
                'customer_email' => 'javier@gmail.com',
                'customer_address' => null,
                'status'         => 'pret',
                'type'           => 'a_emporter',
                'pickup_time'    => Carbon::now()->addMinutes(15),
                'notes'          => null,
                'user_id'        => $customers[1]->id ?? null,
                'item_count'     => 2,
                'created_offset' => -5,
            ],
            [
                'customer_name'  => 'Lucía Fernández',
                'customer_phone' => '+34 612 100 003',
                'customer_email' => 'lucia@gmail.com',
                'customer_address' => 'Avenida de la Constitución 8, Madrid',
                'status'         => 'en_preparation',
                'type'           => 'livraison',
                'pickup_time'    => null,
                'notes'          => 'Allergie aux fruits à coque',
                'user_id'        => $customers[2]->id ?? null,
                'item_count'     => 4,
                'created_offset' => -12,
            ],
            [
                'customer_name'  => 'Pedro Sánchez',
                'customer_phone' => '+34 612 200 001',
                'customer_email' => 'pedro@hotmail.com',
                'customer_address' => null,
                'status'         => 'en_attente',
                'type'           => 'a_emporter',
                'pickup_time'    => Carbon::now()->addMinutes(45),
                'notes'          => null,
                'user_id'        => null,
                'item_count'     => 2,
                'created_offset' => -2,
            ],
            [
                'customer_name'  => 'María Rodríguez',
                'customer_phone' => '+34 612 200 002',
                'customer_email' => 'maria@gmail.com',
                'customer_address' => 'Calle Alcalá 50, Madrid',
                'status'         => 'livre',
                'type'           => 'livraison',
                'pickup_time'    => null,
                'notes'          => 'Appeler à l\'arrivée',
                'user_id'        => null,
                'item_count'     => 3,
                'created_offset' => -20,
            ],
            [
                'customer_name'  => 'Carlos Gutiérrez',
                'customer_phone' => '+34 612 200 003',
                'customer_email' => null,
                'customer_address' => null,
                'status'         => 'en_attente',
                'type'           => 'a_emporter',
                'pickup_time'    => Carbon::now()->addMinutes(60),
                'notes'          => 'Sauce supplémentaire',
                'user_id'        => null,
                'item_count'     => 1,
                'created_offset' => -1,
            ],
            [
                'customer_name'  => 'Elena Torres',
                'customer_phone' => '+34 612 200 004',
                'customer_email' => 'elena@gmail.com',
                'customer_address' => 'Paseo de la Castellana 120, Madrid',
                'status'         => 'en_preparation',
                'type'           => 'livraison',
                'pickup_time'    => null,
                'notes'          => null,
                'user_id'        => null,
                'item_count'     => 5,
                'created_offset' => -8,
            ],
            [
                'customer_name'  => 'Ahmed Benali',
                'customer_phone' => '+34 612 200 005',
                'customer_email' => 'ahmed@gmail.com',
                'customer_address' => 'Calle Fuencarral 85, Madrid',
                'status'         => 'livre',
                'type'           => 'livraison',
                'pickup_time'    => null,
                'notes'          => null,
                'user_id'        => null,
                'item_count'     => 2,
                'created_offset' => -25,
            ],
            [
                'customer_name'  => 'Isabel Navarro',
                'customer_phone' => '+34 612 200 006',
                'customer_email' => 'isabel@hotmail.com',
                'customer_address' => null,
                'status'         => 'annule',
                'type'           => 'a_emporter',
                'pickup_time'    => null,
                'notes'          => 'Commande annulée par le client',
                'user_id'        => null,
                'item_count'     => 2,
                'created_offset' => -10,
            ],
            [
                'customer_name'  => 'Roberto Díaz',
                'customer_phone' => '+34 612 200 007',
                'customer_email' => 'roberto@gmail.com',
                'customer_address' => 'Calle Serrano 40, Madrid',
                'status'         => 'pret',
                'type'           => 'livraison',
                'pickup_time'    => null,
                'notes'          => 'Étage 3, porte B',
                'user_id'        => null,
                'item_count'     => 3,
                'created_offset' => -4,
            ],
        ];

        $orderNumber = 1;

        foreach ($orders as $orderData) {
            $createdAt = Carbon::now()->addMinutes($orderData['created_offset']);
            $dateStr = $createdAt->format('Ymd');
            $orderNum = sprintf('MAR-%s-%03d', $dateStr, $orderNumber);

            // Pick random menu items for this order
            $selectedItems = $menuItems->random(min($orderData['item_count'], $menuItems->count()));
            $itemsJson = [];
            $subtotal = 0;

            foreach ($selectedItems as $menuItem) {
                $qty = rand(1, 3);
                $itemsJson[] = [
                    'id'       => $menuItem->id,
                    'name'     => $menuItem->name,
                    'price'    => (float) $menuItem->price,
                    'quantity' => $qty,
                    'image_url' => $menuItem->image_url,
                ];
                $subtotal += $menuItem->price * $qty;
            }

            $assignedTo = null;
            if ($orderData['type'] === 'livraison' && in_array($orderData['status'], ['en_preparation', 'pret', 'livre'])) {
                $assignedTo = $deliveryUsers->random()->id;
            }

            $order = Order::create([
                'order_number'    => $orderNum,
                'user_id'         => $orderData['user_id'],
                'customer_name'   => $orderData['customer_name'],
                'customer_phone'  => $orderData['customer_phone'],
                'customer_email'  => $orderData['customer_email'],
                'customer_address' => $orderData['customer_address'],
                'pickup_time'     => $orderData['pickup_time'],
                'items'           => $itemsJson,
                'subtotal'        => round($subtotal, 2),
                'total'           => round($subtotal, 2),
                'status'          => $orderData['status'],
                'type'            => $orderData['type'],
                'notes'           => $orderData['notes'],
                'assigned_to'     => $assignedTo,
                'created_at'      => $createdAt,
                'updated_at'      => $createdAt,
            ]);

            // Create normalized order_items
            foreach ($selectedItems as $idx => $menuItem) {
                $qty = $itemsJson[$idx]['quantity'];
                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity'     => $qty,
                    'unit_price'   => $menuItem->price,
                ]);
            }

            // Create delivery record for delivery orders with assigned driver
            if ($assignedTo && $orderData['type'] === 'livraison') {
                $deliveryStatus = match ($orderData['status']) {
                    'en_preparation' => 'en_attente',
                    'pret'           => 'en_cours',
                    'livre'          => 'livre',
                    default          => 'en_attente',
                };

                $assignedAt = (clone $createdAt)->addMinutes(5);
                $pickedUpAt = in_array($deliveryStatus, ['en_cours', 'livre'])
                    ? (clone $assignedAt)->addMinutes(15) : null;
                $deliveredAt = $deliveryStatus === 'livre'
                    ? (clone $pickedUpAt)->addMinutes(25) : null;

                Delivery::create([
                    'order_id'           => $order->id,
                    'delivery_person_id' => $assignedTo,
                    'assigned_at'        => $assignedAt,
                    'picked_up_at'       => $pickedUpAt,
                    'delivered_at'       => $deliveredAt,
                    'status'             => $deliveryStatus,
                    'notes'              => null,
                ]);
            }

            $orderNumber++;
        }
    }
}
