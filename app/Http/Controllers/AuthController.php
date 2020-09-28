<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\UpdatePasswordRequest;
use App\Services\User\GetUserService;
use App\Services\User\LoginUserService;
use App\Services\User\LogoutUserService;
use App\Services\User\RegisterUserService;
use App\Services\User\UpdatePasswordService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginUserService $service)
    {
        return $service->execute($request);
    }

    public function logout(Request $request, LogoutUserService $service)
    {
        return $service->execute($request);
    }

    public function register(RegisterRequest $request, RegisterUserService $service)
    {
        return $service->execute($request);
    }

    public function user(Request $request, GetUserService $service)
    {
        return $service->execute($request);
    }

    public function updatePassword(UpdatePasswordRequest $request, UpdatePasswordService $service)
    {
        return $service->execute($request);
    }
}
