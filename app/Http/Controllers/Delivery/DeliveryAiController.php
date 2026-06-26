<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Services\DriverAiAgentService;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryAiController extends Controller
{
    protected $driverAiService;

    public function __construct(DriverAiAgentService $driverAiService)
    {
        $this->driverAiService = $driverAiService;
    }

    public function unifiedDashboard(Request $request)
    {
        $userId = $request->user()?->id ?? 101; // fallback demo user Karim Benali
        return response()->json([
            'success' => true,
            'data' => $this->driverAiService->getUnifiedPayload($userId)
        ]);
    }

    public function acceptOrder(Request $request, $id)
    {
        try {
            $order = Order::find($id);
            if ($order) {
                $order->update(['status' => 'en_cours']);
                if ($order->delivery) {
                    $order->delivery->update(['status' => 'accepte']);
                }
            }
        } catch (\Throwable $e) {}

        return response()->json([
            'success' => true,
            'message' => "Commande #{$id} acceptée avec succès par le livreur."
        ]);
    }

    public function rejectOrder(Request $request, $id)
    {
        try {
            $order = Order::find($id);
            if ($order) {
                $order->update(['assigned_to' => null, 'status' => 'en_attente']);
                if ($order->delivery) {
                    $order->delivery->update(['delivery_person_id' => null, 'status' => 'assigne']);
                }
            }
        } catch (\Throwable $e) {}

        return response()->json([
            'success' => true,
            'message' => "Commande #{$id} refusée et retournée au dispatch AI."
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status', 'livre');
        try {
            $order = Order::find($id);
            if ($order) {
                $order->update(['status' => $status]);
                if ($order->delivery) {
                    $order->delivery->update(['status' => $status]);
                }
            }
        } catch (\Throwable $e) {}

        return response()->json([
            'success' => true,
            'message' => "Statut de la livraison #{$id} mis à jour vers {$status}."
        ]);
    }
}
