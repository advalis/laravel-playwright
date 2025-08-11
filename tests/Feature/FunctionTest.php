<?php

namespace Advalis\LaravelPlaywright\Tests\Feature;

use Advalis\LaravelPlaywright\Tests\TestCase;

class FunctionTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        include __DIR__ . '/functions.php';
    }

    public function testCallsAFunction() : void
    {
        $this->postJson('/playwright/function', [
            'function' => 'testFunction1'
        ])
            ->assertOk()
            ->assertSee('Hello');
    }

    public function testCallsAFunctionWithArgs() : void
    {
        $this->postJson('/playwright/function', [
            'function' => 'testFunction2',
            'args' => ['William']
        ])
            ->assertOk()
            ->assertSee('Hello William');
    }

    public function testCallsAFunctionWithNamedArgs() : void
    {
        $this->postJson('/playwright/function', [
            'function' => 'testFunction3',
            'args' => [
                'age' => 24,
                'name' => 'William'
            ]
        ])
            ->assertOk()
            ->assertSee('Hello William. You are 24');
    }

    public function testCallsAStaticMethod() : void
    {
        $this->postJson('/playwright/function', [
            'function' => 'testStaticMethodClass1::sayHello',
            'args' => ['me']
        ])
            ->assertOk()
            ->assertSee('Says Hello to me');
    }

    public function testCallsAStaticMethodWithNamespace() : void
    {
        $this->postJson('/playwright/function', [
            'function' => 'Advalis\LaravelPlaywright\Tests\Helpers\TestableStaticMethod::ping',
        ])
            ->assertOk()
            ->assertSee('pong');

    }

}