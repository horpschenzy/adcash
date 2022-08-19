<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function me()
    {
        return $this->loginService->me();
    }
    
    public function login(LoginRequest $request)
    {
        return $this->loginService->login($request);
    }
    
    public function logout()
    {
        return $this->loginService->logout();
    }
}
