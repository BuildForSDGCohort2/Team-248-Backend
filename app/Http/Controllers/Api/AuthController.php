<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, UserService $userService)
    {
        return $userService->login($request);
    }

    public function logout(Request $request, UserService $userService)
    {
        return $userService->logout($request);
    }

    public function register(RegisterRequest $request, UserService $userService)
    {
        return $userService->register($request);
    }

    public function user(Request $request, UserService $userService)
    {
        return $userService->getUserByToken($request);
    }
}
