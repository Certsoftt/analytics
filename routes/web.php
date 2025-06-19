<?php
use Illuminate\Support\Facades\Route;
use Analytics\Http\Controllers\AnalyticsController;

Route::middleware(['web', 'auth', 'can:view-analytics'])
    ->prefix('admin/analytics')
    ->group(function () {
        Route::get('/', [AnalyticsController::class, 'dashboard']);
        Route::get('/goals', [AnalyticsController::class, 'goals']);
        Route::get('/goals/create', [AnalyticsController::class, 'createGoal']);
        Route::post('/goals', [AnalyticsController::class, 'storeGoal']);
        Route::get('/goals/{goal}/edit', [AnalyticsController::class, 'editGoal']);
        Route::put('/goals/{goal}', [AnalyticsController::class, 'updateGoal']);
        Route::put('/goals/update-by-id/{id}', [AnalyticsController::class, 'UpdateGoalById']);
        Route::delete('/goals/{goal}', [AnalyticsController::class, 'deleteGoal']);
        Route::get('/notifications', [AnalyticsController::class, 'notifications']);
    });
