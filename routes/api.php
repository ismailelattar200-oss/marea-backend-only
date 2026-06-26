<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AiController;

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MenuItemController as AdminMenuItemController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DeliveryController as AdminDeliveryController;
use App\Http\Controllers\Admin\JobApplicationController as AdminJobApplicationController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\StatsController as AdminStatsController;
use App\Http\Controllers\Admin\DashboardAiController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Delivery\DeliveryAiController;
use App\Models\User;

// ── Auth ────────────────────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// OAuth
Route::get('/auth/google/redirect', [\App\Http\Controllers\OAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [\App\Http\Controllers\OAuthController::class, 'handleGoogleCallback']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/user/avatar', [UserController::class, 'updateAvatar']);
Route::middleware('auth:sanctum')->delete('/user/avatar', [UserController::class, 'deleteAvatar']);
Route::middleware('auth:sanctum')->get('/user/orders', [UserController::class, 'getOrders']);
Route::middleware('auth:sanctum')->put('/user/profile', [UserController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->put('/user/password', [UserController::class, 'updatePassword']);
Route::middleware('auth:sanctum')->delete('/user', [UserController::class, 'deleteAccount']);

// Users
Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return User::all();
});

// ── Public Routes ───────────────────────────────────────────────
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/menu-items', [MenuItemController::class, 'index']);
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{order_number}', [OrderController::class, 'show']);

Route::post('/contact', [ContactController::class, 'store']);
Route::post('/job-applications', [JobApplicationController::class, 'store']);

// AI Assistant
Route::post('/chat', [AiController::class, 'chat']);

// ── Admin Routes (Protected via Sanctum) ────────────────────────
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    
    // Stats & AI Agent Dashboard
    Route::get('/stats', [AdminStatsController::class, 'index']);
    Route::get('/driver-alerts', [DashboardAiController::class, 'driverAlerts']);
    Route::get('/performance-analytics', [DashboardAiController::class, 'performanceAnalytics']);
    Route::get('/ai-recommendations', [DashboardAiController::class, 'aiRecommendations']);
    Route::get('/promotions', [DashboardAiController::class, 'promotionsIndex']);
    Route::post('/promotions', [DashboardAiController::class, 'promotionsStore']);
    Route::get('/promotions/ai-suggestions', [DashboardAiController::class, 'promotionsSuggestions']);
    Route::get('/live-tracking', [DashboardAiController::class, 'liveTracking']);
    Route::get('/feedbacks', [DashboardAiController::class, 'feedbacksIndex']);
    Route::get('/feedbacks/ai-summary', [DashboardAiController::class, 'feedbacksSummary']);
    Route::get('/revenue-analytics', [DashboardAiController::class, 'revenueAnalytics']);

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index']);
    Route::post('/categories', [AdminCategoryController::class, 'store']);
    Route::post('/categories/reorder', [AdminCategoryController::class, 'reorder']);
    Route::get('/categories/{category}', [AdminCategoryController::class, 'show']);
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update']);
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy']);

    // Menu Items
    Route::get('/menu-items', [AdminMenuItemController::class, 'index']);
    Route::post('/menu-items', [AdminMenuItemController::class, 'store']);
    Route::get('/menu-items/{menuItem}', [AdminMenuItemController::class, 'show']);
    Route::put('/menu-items/{menuItem}', [AdminMenuItemController::class, 'update']);
    Route::delete('/menu-items/{menuItem}', [AdminMenuItemController::class, 'destroy']);

    // Events
    Route::get('/events', [AdminEventController::class, 'index']);
    Route::post('/events', [AdminEventController::class, 'store']);
    Route::get('/events/{event}', [AdminEventController::class, 'show']);
    Route::put('/events/{event}', [AdminEventController::class, 'update']);
    Route::delete('/events/{event}', [AdminEventController::class, 'destroy']);

    // Gallery
    Route::get('/gallery', [AdminGalleryController::class, 'index']);
    Route::post('/gallery', [AdminGalleryController::class, 'store']);
    Route::put('/gallery/{galleryPhoto}', [AdminGalleryController::class, 'update']);
    Route::delete('/gallery/{galleryPhoto}', [AdminGalleryController::class, 'destroy']);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{order}', [AdminOrderController::class, 'show']);
    Route::put('/orders/{order}', [AdminOrderController::class, 'update']);

    // Deliveries
    Route::get('/deliveries', [AdminDeliveryController::class, 'index']);
    Route::get('/deliveries/orders', [AdminDeliveryController::class, 'deliveryOrders']);
    Route::get('/deliveries/stats', [AdminDeliveryController::class, 'stats']);
    Route::get('/deliveries/persons', [AdminDeliveryController::class, 'deliveryPersons']);
    Route::post('/deliveries', [AdminDeliveryController::class, 'store']);
    Route::put('/deliveries/{id}/assign', [AdminDeliveryController::class, 'assign']);
    Route::put('/deliveries/{delivery}', [AdminDeliveryController::class, 'update']);

    // Job Applications
    Route::get('/job-applications', [AdminJobApplicationController::class, 'index']);
    Route::put('/job-applications/{jobApplication}/review', [AdminJobApplicationController::class, 'review']);
    Route::delete('/job-applications/{jobApplication}', [AdminJobApplicationController::class, 'destroy']);

    // Contacts
    Route::get('/contacts', [AdminContactController::class, 'index']);
    Route::put('/contacts/{contact}/read', [AdminContactController::class, 'read']);
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy']);

    // Users
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::post('/users', [AdminUserController::class, 'store']);
    Route::put('/users/{user}', [AdminUserController::class, 'update']);
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy']);
});

// ── Delivery AI Agent Routes ────────────────────────────────────
Route::prefix('delivery')->group(function () {
    Route::get('/unified-dashboard', [DeliveryAiController::class, 'unifiedDashboard']);
    Route::post('/orders/{id}/accept', [DeliveryAiController::class, 'acceptOrder']);
    Route::post('/orders/{id}/reject', [DeliveryAiController::class, 'rejectOrder']);
    Route::put('/orders/{id}/status', [DeliveryAiController::class, 'updateStatus']);
});




