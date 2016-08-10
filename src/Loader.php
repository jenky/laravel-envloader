<?php

namespace Jenky\LaravelEnvLoader;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class Loader
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Class constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Explode the enviroment name.
     *
     * @param string $environment
     *
     * @return array
     */
    protected function explodeEnvironment($environment)
    {
        return (is_string($environment)) ? explode('|', $environment) : $environment;
    }

    /**
     * Overwrite the original config value based
     * on environment name.
     *
     * @param array        $configs
     * @param Closure|null $closure
     *
     * @return void
     */
    protected function loadData($configs, Closure $closure = null)
    {
        if (is_null($configs)) {
            return false;
        }

        foreach ($configs as $env => $config) {
            $env = $this->explodeEnvironment($env);

            if (is_array($env)) {
                foreach ($env as $_env) {
                    if ($this->app->environment($_env)) {
                        $closure($config);
                    }
                }
            } else {
                if ($this->app->environment($env)) {
                    $closure($config);
                }
            }
        }
    }

    /**
     * Load the config values.
     *
     * @return \Jenky\LaravelEnvLoader\Loader
     */
    public function loadConfigs()
    {
        $this->loadData(config('env.configs'), function ($configs) {
            $configs = array_dot($configs);
            $this->app['config']->set($configs);
        });

        return $this;
    }

    /**
     * Load the providers.
     *
     * @return \Jenky\LaravelEnvLoader\Loader
     */
    public function loadProviders()
    {
        $this->loadData(config('env.providers'), function ($configs) {
            if (!empty($configs) && is_array($configs)) {
                foreach ($configs as $config) {
                    $this->app->register($config);
                }
            }
        });

        return $this;
    }

    /**
     * Load the aliases.
     *
     * @return \Jenky\LaravelEnvLoader\Loader
     */
    public function loadAliases()
    {
        $this->loadData(config('env.aliases'), function ($configs) {
            if (!empty($configs) && is_array($configs)) {
                foreach ($configs as $alias => $class) {
                    $this->app->alias($alias, $class);
                }
            }
        });

        return $this;
    }
}
