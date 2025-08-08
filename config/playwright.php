<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Playwright Testing Configuration
	|--------------------------------------------------------------------------
	|
	| Configuration for Laravel Playwright integration
	|
	*/

	'enabled' => env('PLAYWRIGHT_ENABLED', env('APP_ENV') === 'local' || env('APP_ENV') === 'testing'),

	'routes' => [
		'prefix' => '__playwright',
		'middleware' => [],
	],

	'database' => [
		'reset_between_tests' => true,
		'seed_database' => false,
	],
];