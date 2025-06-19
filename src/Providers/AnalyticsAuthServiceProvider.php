<?php
namespace Analytics\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AnalyticsAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Gate::define('analytics.export', function ($user) {
            return $user->hasRole('admin') || $user->hasPermissionTo('analytics.export');
        });
    }
}
