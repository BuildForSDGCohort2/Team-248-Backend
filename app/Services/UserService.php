<?php

namespace App\Services;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\User;
use App\Repositories\OfferRepository;
use App\Repositories\StatusRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
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

    public function logout(Request $request, UserService $userService)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return new SuccessResource(Response::HTTP_CREATED, "Logged out In successfully.");
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error", ["An unexpected error occured."]);
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->userRepository->create($request->validated());
            $token = $user->createToken('authToken')->plainTextToken;
            return new SuccessResource(Response::HTTP_CREATED, "Registred successfully.", [
                'user' => $user,
                'token' => $token
            ]);

        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error", ["An unexpected error occured."]);
        }
    }

    public function getUserByToken(Request $request)
    {
        try {
            return new SuccessResource(Response::HTTP_CREATED, "Fetched successfully.", ['user' => $request->user()]);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error", ["An unexpected error occured."]);
        }
    }

    public function forgetPassword()
    {
    }

    private function checkPassword($plainText, $hashedText)
    {
        return Hash::check($plainText, $hashedText);
    }
}
