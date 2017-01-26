<?php

namespace Jenssegers\Agent;

use Illuminate\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('Jenssegers\Agent\Contracts\Agent', function ($app) {
            return new Agent($app['request']->server->all());
        });
        $this->app->singleton('agent', 'Jenssegers\Agent\Contracts\Agent');
    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Jenssegers\Agent\Contracts\Agent',
            'agent',
        ];
    }
}
