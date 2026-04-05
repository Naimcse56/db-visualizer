<?php
namespace Naimul\DbVisualizer;

use Illuminate\Support\ServiceProvider;

class DbVisualizerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/db-visualizer.php', 'db-visualizer');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__.'/../config/db-visualizer.php' => config_path('db-visualizer.php'),
        ], 'dbv-config');
        
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'dbv');

        $this->publishes([
            __DIR__.'/Resources/views' => resource_path('views/vendor/dbv'),
        ], 'dbv-views');
    }
}