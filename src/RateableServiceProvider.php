<?php

namespace willvincent\Rateable;

use Illuminate\Support\ServiceProvider;
use willvincent\Rateable\Commands\RateableCommand;

class RateableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateRatingsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_ratings_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_ratings_table.php'),
                ], 'migrations');
            }

            // $this->publishes([
            //     __DIR__.'/../config/rateable.php' => config_path('rateable.php'),
            // ], 'config');

            // $this->commands([
            //     RateableCommand::class,
            // ]);
        }
    }

    // public function register()
    // {
    //     $this->mergeConfigFrom(__DIR__.'/../config/rateable.php', 'rateable');
    // }
}
