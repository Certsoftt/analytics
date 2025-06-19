<?php
use Illuminate\Support\Facades\Route;
use Analytics\Http\Controllers\AnalyticsController;

Route::middleware(['api', 'auth:api', 'can:view-analytics'])
    ->prefix('analytics')
    ->group(function () {
        Route::get('/stats', [AnalyticsController::class, 'stats']);
        Route::get('/export', [AnalyticsController::class, 'export']);
        Route::get('/geo', [AnalyticsController::class, 'geo']);
        Route::get('/engagement', [AnalyticsController::class, 'engagement']);
        Route::get('/realtime-users', [AnalyticsController::class, 'realtimeUsers']);
        Route::get('/geo-map', [AnalyticsController::class, 'geoMap']);
        Route::post('/test-notification', [AnalyticsController::class, 'storeNotificationTest']);
    });
