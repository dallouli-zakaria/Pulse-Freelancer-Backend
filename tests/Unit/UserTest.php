<?php
namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testThatTrueIsTrue()
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
    }
}
