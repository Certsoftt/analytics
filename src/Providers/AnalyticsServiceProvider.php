<?php
namespace Analytics\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class AnalyticsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes, views, translations only if plugin is active
        if (Config::get('analytics.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
            $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
            $this->loadViewsFrom(__DIR__.'/../../views', 'analytics');
            $this->loadTranslationsFrom(__DIR__.'/../../lang', 'analytics');
            $this->publishes([
                __DIR__.'/../../public' => public_path('plugins/analytics'),
            ], 'public');

            // Register dashboard widget directive
            Blade::directive('analyticsWidget', function () {
                return "<?php if (config('analytics.enabled')) echo view('analytics::widgets.dashboard-analytics')->render(); ?>";
            });
        }

        // Register the AuthServiceProvider for permissions
        $this->app->register(\Analytics\Providers\AnalyticsAuthServiceProvider::class);
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'analytics');
    }
}
