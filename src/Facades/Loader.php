<?php namespace Jenky\LaravelEnvLoader\Facades;

use Illuminate\Support\Facades\Facade;

class Loader extends Facade {
	
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'envloader'; }
}