<?php

namespace App\Services;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\User;
use App\Repositories\OfferRepository;
use App\Repositories\StatusRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->findWhere(['email' => $request->input('email')])->first();

        if (!$user || !$this->checkPassword($request->input('password'), $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        try {
            $token = $user->createToken('authToken')->plainTextToken;
            return new SuccessResource(Response::HTTP_CREATED, "Logged In successfully.", [
                'user' => $user,
                'token' => $token
            ]);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error", ["An unexpected error occured."]);
        }
    }

    public function logout()
    {
    }

    public function register()
    {
    }

    public function getUserByToken()
    {
    }

    public function forgetPassword()
    {
    }

    private function checkPassword($plainText, $hashedText)
    {
        return Hash::check($plainText, $hashedText);
    }
}
