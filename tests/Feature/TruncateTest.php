<?php

namespace Advalis\LaravelPlaywright\Tests\Feature;

use Advalis\LaravelPlaywright\Tests\Helpers\UserModel;
use Advalis\LaravelPlaywright\Tests\TestCase;

class TruncateTest extends TestCase
{
    public function testTruncates(): void
    {
        UserModel::factory()->count(3)->create();
        $this->assertCount(3, UserModel::all());

        $this->postJson('/playwright/truncate');

        $this->assertCount(0, UserModel::all());
    }
}