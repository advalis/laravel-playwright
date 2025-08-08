<?php declare(strict_types=1);

namespace Advalis\LaravelPlaywright;

use Advalis\LaravelPlaywright\Testing\OAuth2Helper;
use Advalis\LaravelPlaywright\Testing\TenantHelper;
use Advalis\LaravelPlaywright\Testing\ReverbHelper;
use Advalis\LaravelPlaywright\Testing\FinCENHelper;
use Advalis\LaravelPlaywright\Services\Config;
use Advalis\LaravelPlaywright\Services\DynamicConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class LaravelPlaywrightServiceProvider extends BaseServiceProvider
{

    public function boot() : void
    {
        if (App::environment(...Config::envs())) {
            $this->loadRoutesFrom(__DIR__ . '/routes/e2e.php');

            /** @var DynamicConfig $dynamicConfig */
            $dynamicConfig = app(DynamicConfig::class);
            $dynamicConfig->load();
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/playwright.php' => config_path('playwright.php'),
            ], 'playwright-config');
        }

        // Only load routes in testing/local environment
        if ($this->app->environment(['local', 'testing'])) {
            $this->loadRoutesFrom(__DIR__.'/routes/playwright.php');
        }



        if ($this->app->environment(['local', 'testing'])) {
            Route::prefix('__playwright')->group(function () {
                Route::post('oauth/mock-login', function (Request $request) {
                    $helper = app(OAuth2Helper::class);
                    $user = \App\Models\User::find($request->user_id);
                    return $helper->loginAs($user);
                });

                Route::post('tenant/switch', function (Request $request) {
                    $helper = app(TenantHelper::class);
                    $helper->switchToFirm($request->firm_id);
                    $helper->switchToOffice($request->office_id);
                    return ['success' => true];
                });
            });
        }

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/playwright.php', 'playwright');

        // Register custom helpers
        $this->app->singleton(OAuth2Helper::class);
        $this->app->singleton(TenantHelper::class);
        $this->app->singleton(ReverbHelper::class);
        $this->app->singleton(FinCENHelper::class);
    }

}