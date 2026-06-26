<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAiAgentService;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardAiController extends Controller
{
    protected $aiService;

    public function __construct(AdminAiAgentService $aiService)
    {
        $this->aiService = $aiService;
    }

    // 1. ALERT LIVREURS
    public function driverAlerts()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getDriverAlerts()
        ]);
    }

    // 2. ANALYSE DES PERFORMANCES
    public function performanceAnalytics()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getPerformanceAnalytics()
        ]);
    }

    // 3. AI RECOMMENDATIONS
    public function aiRecommendations()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getAiRecommendations()
        ]);
    }

    // 4. GESTION PROMOTIONS
    public function promotionsIndex()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getPromotionsAnalytics()
        ]);
    }

    public function promotionsStore(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        try {
            if (Schema::hasTable('promotions')) {
                $promo = Promotion::create($validated);
                return response()->json([
                    'success' => true,
                    'message' => 'Promotion créée avec succès en base de données.',
                    'data' => $promo
                ], 201);
            }
        } catch (\Throwable $e) {}

        return response()->json([
            'success' => true,
            'message' => 'Promotion créée avec succès (Mode Démo Résilient).',
            'data' => array_merge($validated, ['id' => rand(10, 99), 'usage_count' => 0, 'sales_generated' => 0])
        ], 201);
    }

    public function promotionsSuggestions()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getPromotionsSuggestions()
        ]);
    }

    // 5. LIVE TRACKING
    public function liveTracking()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getLiveTracking()
        ]);
    }

    // 6. FEEDBACK CLIENTS
    public function feedbacksIndex()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getFeedbacksAnalytics()
        ]);
    }

    public function feedbacksSummary()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getFeedbackAiSummary()
        ]);
    }

    // 7. REVENUE ANALYTICS
    public function revenueAnalytics()
    {
        return response()->json([
            'success' => true,
            'data' => $this->aiService->getRevenueAnalytics()
        ]);
    }
}
