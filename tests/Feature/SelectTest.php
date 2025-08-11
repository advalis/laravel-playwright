<?php

namespace Advalis\LaravelPlaywright\Tests\Feature;

use Advalis\LaravelPlaywright\Tests\Helpers\UserModel;
use Advalis\LaravelPlaywright\Tests\TestCase;

class SelectTest extends TestCase
{
    public function testSelectsAUser(): void
    {
        $user = UserModel::factory()->create();

        $response = $this->postJson('/playwright/select', [
            'query' => 'select * from users where id = ' . $user->id
        ]);

        $response->assertOk();
        $response->assertJsonPath('0.id', $user->id);
    }
}