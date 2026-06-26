<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use App\Http\Resources\DeliveryResource;
use App\Http\Resources\OrderResource;
use App\Mail\OrderDeliveredMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * List all deliveries with optional filters.
     * Supports filtering by status, delivery_person_id.
     */
    public function index(Request $request)
    {
        $query = Delivery::with(['order', 'deliveryPerson'])
            ->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('delivery_person_id')) {
            $query->where('delivery_person_id', $request->delivery_person_id);
        }

        $deliveries = $query->get();
        return DeliveryResource::collection($deliveries);
    }

    /**
     * Get all delivery orders (type = domicilio) with their delivery info.
     * This powers the main Repartos table view.
     */
    public function deliveryOrders(Request $request)
    {
        $query = Order::with(['assignedDriver', 'delivery.deliveryPerson', 'orderItems.menuItem'])
            ->where('type', 'livraison')
            ->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();
        return OrderResource::collection($orders);
    }

    /**
     * Assign a delivery person to an order.
     * Creates a delivery record and updates the order's assigned_to.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_person_id' => 'required|exists:users,id',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        if ($order->type !== 'livraison') {
            return response()->json(['message' => 'La commande doit être de type livraison'], 422);
        }

        // Verify the user is a delivery person
        $deliveryPerson = User::findOrFail($validated['delivery_person_id']);
        if ($deliveryPerson->role !== 'delivery') {
            return response()->json(['message' => 'User must have delivery role'], 422);
        }

        $delivery = Delivery::updateOrCreate(
            ['order_id' => $validated['order_id']],
            [
                'delivery_person_id' => $validated['delivery_person_id'],
                'status' => 'en_cours',
                'assigned_at' => now(),
            ]
        );

        $order->update([
            'assigned_to' => $validated['delivery_person_id'],
        ]);

        return new DeliveryResource($delivery->load(['order', 'deliveryPerson']));
    }

    /**
     * Assign a delivery person to an order.
     * PUT /api/admin/deliveries/{id}/assign
     */
    public function assign(Request $request, $id)
    {
        $validated = $request->validate([
            'delivery_person_id' => 'required|exists:users,id',
        ]);

        $order = Order::findOrFail($id);

        if ($order->type !== 'livraison') {
            return response()->json(['message' => 'La commande doit être de type livraison'], 422);
        }

        $deliveryPerson = User::findOrFail($validated['delivery_person_id']);
        if ($deliveryPerson->role !== 'delivery') {
            return response()->json(['message' => 'User must have delivery role'], 422);
        }

        $delivery = Delivery::updateOrCreate(
            ['order_id' => $id],
            [
                'delivery_person_id' => $validated['delivery_person_id'],
                'status' => 'en_attente',
                'assigned_at' => now(),
            ]
        );

        $order->update([
            'assigned_to' => $validated['delivery_person_id'],
            'status' => 'en_attente'
        ]);

        return new DeliveryResource($delivery->load(['order', 'deliveryPerson']));
    }

    /**
     * Update delivery status with timestamp tracking.
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'status' => 'required|in:en_attente,en_cours,en_preparation,pret,livre',
            'notes' => 'nullable|string',
        ]);

        $updateData = ['status' => $validated['status']];

        // Set timestamps based on status transitions
        if ($validated['status'] === 'en_preparation' && !$delivery->picked_up_at) {
            $updateData['picked_up_at'] = now();
        } elseif ($validated['status'] === 'livre' && !$delivery->delivered_at) {
            $updateData['delivered_at'] = now();
            // Sync order status to livre
            $delivery->order->update(['status' => 'livre']);
            
            if ($delivery->order->customer_email) {
                $order = $delivery->order->load('orderItems.menuItem');
                try {
                    Mail::to($order->customer_email)->send(new OrderDeliveredMail($order));
                } catch (\Exception $e) {
                    \Log::error('Erreur envoi email livraison: ' . $e->getMessage());
                }
            }
        }

        if (isset($validated['notes'])) {
            $updateData['notes'] = $validated['notes'];
        }

        $delivery->update($updateData);

        return new DeliveryResource($delivery->load(['order', 'deliveryPerson']));
    }

    /**
     * Delivery-specific statistics for the Repartos dashboard.
     * Returns: active deliveries, today's total, avg delivery time, most active driver.
     */
    public function stats()
    {
        $today = Carbon::today();

        // Active deliveries (not yet delivered)
        $activeCount = Delivery::whereIn('status', ['en_attente', 'en_cours', 'en_preparation'])->count();

        // Today's deliveries (created or completed today)
        $todayCount = Delivery::whereDate('created_at', $today)->count();

        // Average delivery time in minutes (from assigned_at to delivered_at) for completed deliveries
        $avgTime = Delivery::where('status', 'livre')
            ->whereNotNull('assigned_at')
            ->whereNotNull('delivered_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, assigned_at, delivered_at)) as avg_minutes')
            ->value('avg_minutes');

        // Most active delivery person (most deliveries today or overall active)
        $mostActive = Delivery::select('delivery_person_id', DB::raw('COUNT(*) as total'))
            ->whereDate('created_at', $today)
            ->groupBy('delivery_person_id')
            ->orderByDesc('total')
            ->with('deliveryPerson')
            ->first();

        return response()->json([
            'livraisons_actives' => $activeCount,
            'livraisons_aujourdhui' => $todayCount,
            'temps_moyen_minutes' => $avgTime ? round($avgTime) : null,
            'repartidor_actif' => $mostActive ? [
                'name' => $mostActive->deliveryPerson->name ?? 'N/A',
                'count' => $mostActive->total,
            ] : null,
        ]);
    }

    /**
     * Get delivery persons with their active delivery workload.
     * Used for the workload panel and assignment dropdown.
     */
    public function deliveryPersons()
    {
        $deliveryUsers = User::where('role', 'delivery')->get();

        $workload = Delivery::whereIn('status', ['en_attente', 'en_cours', 'en_preparation'])
            ->select('delivery_person_id', DB::raw('COUNT(*) as active_count'))
            ->groupBy('delivery_person_id')
            ->pluck('active_count', 'delivery_person_id');

        $result = $deliveryUsers->map(function ($user) use ($workload) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'active_deliveries' => $workload->get($user->id, 0),
            ];
        });

        return response()->json(['data' => $result]);
    }
}
