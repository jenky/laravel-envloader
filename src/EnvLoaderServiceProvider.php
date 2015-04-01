<?php namespace Jenky\LaravelEnvLoader;

use Illuminate\Support\ServiceProvider;

class EnvLoaderServiceProvider extends ServiceProvider {

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

		$configPaths = [
			'aliases' => __DIR__ . '/../config/aliases.php',
			'configs' => __DIR__ . '/../config/configs.php',
			'providers' => __DIR__ . '/../config/providers.php',
		];

		foreach ($configPaths as $key => $path) 
		{
			$this->mergeConfigFrom($path, 'env.' . $key);
		}

		$this->app['envloader'] = $this->app->share(function($app)
		{
			return $app->make('Jenky\LaravelEnvLoader\Loader');
		});
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$configPath = __DIR__ . '/../config';
		
		$this->publishes([
			$configPath . '/aliases.php' => config_path('env/aliases.php'),
			$configPath . '/configs.php' => config_path('env/configs.php'),
			$configPath . '/providers.php' => config_path('env/providers.php')
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
