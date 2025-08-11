<?php

namespace Advalis\LaravelPlaywright\Tests\Feature;

use Advalis\LaravelPlaywright\Tests\Helpers\UserModel;
use Advalis\LaravelPlaywright\Tests\TestCase;

class QueryTest extends TestCase
{

    public function testRunsAQuery() : void
    {
        $users = UserModel::factory()
            ->count(3)
            ->create();

        $this->postJson('/playwright/query', [
            'query' => "update users set name = 'John Doe' where id = " . $users[0]?->id
        ])->assertOk();

        $this->assertEquals('John Doe', $users[0]?->refresh()->name);
    }

}