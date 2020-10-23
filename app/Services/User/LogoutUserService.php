<?php

namespace App\Services\User;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutUserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(Request $request)
    {
        try {
            Auth::guard()->logout();
            return new SuccessResource(Response::HTTP_OK, "Logged out successfully.");
        } catch (Exception $e) {
            Log::info($e);
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
