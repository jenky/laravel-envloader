<?php

namespace Jenky\LaravelEnvLoader;

use Illuminate\Support\ServiceProvider;

class EnvLoaderServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEnvLoader();
    }

    /**
     * Register the env loader class.
     *
     * @return void
     */
    protected function registerEnvLoader()
    {
        $this->app->singleton('envloader', function ($app) {
            return new Loader($app);
        });

        $this->app['envloader']->loadConfigs()->loadProviders()->loadAliases();
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $configPath = __DIR__.'/../config';

        $this->publishes([
            $configPath.'/aliases.php'   => config_path('env/aliases.php'),
            $configPath.'/configs.php'   => config_path('env/configs.php'),
            $configPath.'/providers.php' => config_path('env/providers.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['envloader'];
    }
}
