<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        User::factory(1)->create();
        $user = User::first();
        $response = $this->post('/api/v1/auth/login',[
            'email' => $user->email,
            'password' => 'password'
        ]);
        $data = $response->json();
        $this->assertEquals($data['status'], true);
        $response->assertStatus(200);
    }
}
