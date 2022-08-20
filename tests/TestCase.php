<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $token;

    protected function login()
    {   
        User::factory(1)->create();
        $user = User::first();
        $response = $this->post('/api/v1/auth/login',[
            'email' => $user->email,
            'password' => 'password'
        ]);
        $data = $response->json();
        $this->token = $data['data']['access_token'];
        JWTAuth::setToken($this->token);

        Auth::login($user);
        return $this->token;
    }

}
