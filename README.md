## Laravel 5 environment loader

[![Latest Stable Version](https://poser.pugx.org/jenky/laravel-envloader/v/stable.svg)](https://packagist.org/packages/jenky/laravel-envloader) 
[![Total Downloads](https://poser.pugx.org/jenky/laravel-envloader/d/total.svg)](https://packagist.org/packages/jenky/laravel-envloader) 
[![License](https://poser.pugx.org/jenky/laravel-envloader/license.svg)](https://packagist.org/packages/jenky/laravel-envloader)

Load configs, providers, aliases based on the `APP_ENV` name in `.env`.

## Installation
Require this package with composer:

```
composer require jenky/laravel-envloader ~1.0
```

or add this to `composer.json`

```
"jenky/laravel-envloader": "~1.0"
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`. Make sure the `EnvLoaderServiceProvider` is loaded before other app service providers.
```php
'Jenky\LaravelEnvLoader\EnvLoaderServiceProvider',
// or 
Jenky\LaravelEnvLoader\EnvLoaderServiceProvider::class, // PHP 5.5

/*
 * Application Service Providers...
 */
App\Providers\AppServiceProvider::class,
App\Providers\EventServiceProvider::class,
App\Providers\RouteServiceProvider::class,
// ... 
```

Copy the package config to your local config with the publish command:

```
php artisan vendor:publish
```
The config files will be published to `config/app/env`

## Usage

Modify the config files in `config/app/env` to suite your needs
```php
/* configs.php */

return [
	'local' => [
		'app' => [
			'url' => 'http://myapp.local',
		],
	],
	'sandbox' => [
		'app' => [
			'url' => 'http://sandbox.myapp.com',
		],
	],
	'testing' => [
		'session' => [
			'driver' => 'file',
		],
	],
];
```

Multiple environments may be delimited using a "pipe" character
```php
/* aliases.php */

return [
	'local|staging' => [
		'Debugbar' => 'Barryvdh\Debugbar\Facade',
	],
];
```
