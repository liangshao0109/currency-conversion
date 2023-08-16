<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_making_an_api_request(): void
    {
        $response = $this->getJson(route('currency-conversion', ['source' => 'USD', 'target' => 'JPY', 'amount' => '$1,525']));

        $response
            ->assertStatus(200)
            ->assertJson([
                'msg' => 'success',
                'amount' => '$170,496.53',
            ]);
    }
}
