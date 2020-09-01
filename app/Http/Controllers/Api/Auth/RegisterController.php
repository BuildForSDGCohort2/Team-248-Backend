<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use App\Services\UserService;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest$request, UserService $userService)
    {
        return $userService->register($request);
    }
}
