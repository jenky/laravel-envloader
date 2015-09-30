<?php

namespace Jenky\LaravelEnvLoader;

use Closure;

class Loader
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    protected function explodeEnvironment($environment)
    {
        return (is_string($environment)) ? explode('|', $environment) : $environment;
    }

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

    public function loadConfigs()
    {
        $this->loadData(config('env.configs'), function ($configs) {
            $configs = array_dot($configs);
            config($configs);
        });

        return $this;
    }

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
