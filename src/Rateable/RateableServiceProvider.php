<?php namespace willvincent\Rateable;

use Illuminate\Support\ServiceProvider;

class RateableServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->commands('command.rateable.migration');
        $this->app->bind('command.rateable.migration', function ($app) {
            return new MigrationCommand();
        }, TRUE);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.rateable.migration',
        ];
    }
}
