<?php

namespace Advalis\LaravelPlaywright\Tests;

use Advalis\LaravelPlaywright\ServiceProvider;
use Advalis\LaravelPlaywright\Services\DynamicConfig;
use Advalis\LaravelPlaywright\Tests\Helpers\Migrations;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        Migrations::run();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        DynamicConfig::delete();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

}
