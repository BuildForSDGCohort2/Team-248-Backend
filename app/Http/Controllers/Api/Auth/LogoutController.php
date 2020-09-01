<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request, UserService $userService)
    {
        return $userService->logout($request);
    }
}
