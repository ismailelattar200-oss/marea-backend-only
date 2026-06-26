<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['orderItems.menuItem', 'assignedDriver', 'delivery'])
            ->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->byStatus($request->status);
        }
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Pagination for real app, but for demo get all
        $orders = $query->get();
        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        return new OrderResource($order->load(['orderItems.menuItem', 'assignedDriver', 'delivery']));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:en_attente,en_preparation,pret,en_cours,livre,annule',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $order->update($validated);

        // If status updated and has delivery, update delivery status too if applicable
        if ($order->type === 'livraison' && $order->delivery) {
             if ($validated['status'] === 'livre') {
                 $order->delivery->update([
                     'status' => 'livre',
                     'delivered_at' => now()
                 ]);
             }
        }

        return new OrderResource($order->load(['assignedDriver', 'delivery']));
    }
}
