<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_first_name' => 'required|string|max:255',
            'customer_last_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required_if:type,livraison|nullable|string|max:255',
            'customer_region' => 'required_if:type,livraison|nullable|string|max:255',
            'customer_city' => 'required_if:type,livraison|nullable|string|max:255',
            'customer_postal_code' => 'required_if:type,livraison|nullable|string|max:20',
            'type' => 'required|in:a_emporter,livraison',
            'payment_method' => 'required|in:carte,paypal,especes',
            'pickup_time' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.name' => 'required|string',
            'items.*.image_url' => 'nullable|string',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        if ($validated['type'] === 'livraison' && empty($validated['customer_address'])) {
            return response()->json(['message' => 'L\'adresse est obligatoire pour les livraisons'], 422);
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth('sanctum')->id(),
                'customer_name' => $validated['customer_first_name'] . ' ' . $validated['customer_last_name'],
                'customer_first_name' => $validated['customer_first_name'],
                'customer_last_name' => $validated['customer_last_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'customer_address' => $validated['customer_address'] ?? null,
                'customer_region' => $validated['customer_region'] ?? null,
                'customer_city' => $validated['customer_city'] ?? null,
                'customer_postal_code' => $validated['customer_postal_code'] ?? null,
                'pickup_time' => $validated['pickup_time'] ?? null,
                'items' => $validated['items'],
                'subtotal' => $validated['subtotal'],
                'total' => $validated['total'],
                'status' => 'en_attente',
                'type' => $validated['type'],
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);
            }

            DB::commit();

            try {
                Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                Log::error('Failed to send order confirmation email: ' . $e->getMessage());
                // We don't want to fail the order creation if the email fails, so we just log it.
            }

            return new OrderResource($order);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating order: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors du traitement de la commande'], 500);
        }
    }

    public function show($order_number)
    {
        $order = Order::with(['orderItems.menuItem', 'assignedDriver', 'delivery'])
            ->where('order_number', $order_number)
            ->firstOrFail();

        return new OrderResource($order);
    }
}
