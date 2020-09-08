<?php

namespace App\Services\User;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(LoginRequest $request)
    {
        $user = $this->userRepository->findWhere(['email' => $request->input('email')])->first();

        if (!$user || !$this->checkPassword($request->input('password'), $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        try {
            $token = $user->createToken('authToken')->plainTextToken;
            return new SuccessResource(Response::HTTP_OK, "Logged In successfully.", [
                'user' => new UserResource($user),
                'token' => $token
            ]);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }

    private function checkPassword($plainText, $hashedText)
    {
        return Hash::check($plainText, $hashedText);
    }
}