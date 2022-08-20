<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
}
