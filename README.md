## Laravel 5 environment loader

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

After updating composer, add the ServiceProvider to the providers array in `config/app.php`
```php
'Jenky\LaravelEnvLoader\EnvLoaderServiceProvider',
```

Add this to your facades in `config/app.php`:

```php
'EnvLoader' => 'Jenky\LaravelEnvLoader\Facades\Loader',
```

Copy the package config to your local config with the publish command:

```
php artisan vendor:publish
```
The config files will be published to `config/app/env`

Edit your `app/Providers/AppServiceProvider.php` add
```php
\EnvLoader::loadProviders()->loadAliases();
```

and `app/Providers/ConfigServiceProvider.php` add
```php
\EnvLoader::loadConfigs();
```
to the `register` function 


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