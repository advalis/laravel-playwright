<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix(config('playwright.routes.prefix', '__playwright'))
	->middleware(config('playwright.routes.middleware', []))
	->group(function () {

		// Factory endpoint
		Route::post('/factory', function (Request $request) {
			$model = $request->input('model');
			$attributes = $request->input('attributes', []);
			$count = $request->input('count', 1);

			$modelClass = "App\\Models\\{$model}";

			if (!class_exists($modelClass)) {
				return response()->json(['error' => 'Model not found'], 404);
			}

			return $modelClass::factory($count)->create($attributes);
		});

		// Database operations
		Route::post('/db/truncate', function (Request $request) {
			$tables = $request->input('tables', []);

			foreach ($tables as $table) {
				\DB::table($table)->truncate();
			}

			return response()->json(['success' => true]);
		});

		// Artisan commands
		Route::post('/artisan', function (Request $request) {
			$command = $request->input('command');
			$parameters = $request->input('parameters', []);

			\Artisan::call($command, $parameters);

			return response()->json([
				'output' => \Artisan::output(),
				'exit_code' => \Artisan::exitCode(),
			]);
		});
	});