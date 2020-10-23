<?php

namespace App\Services\User;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;

class LoginUserService
{
    protected $userRepository;

    /**
     * @var JWTAuth
     */
    private $jwt = NULL;

    public function __construct(UserRepository $userRepository, JWTAuth $jwt)
    {
        $this->userRepository = $userRepository;
        $this->jwt = $jwt;
    }

    public function execute(LoginRequest $request)
    {
        $user = $this->userRepository->findWhere(['email' => $request->input('email')])->first();

        try {
            //Check if user credentials are correct
            if (!$token = $this->jwt->attempt(['email' => $request->input('email'),'password' => $request->input('password')])) {
                return new ErrorResource(Response::HTTP_NOT_FOUND, "These credentials do not match our records.");
            }

            $this->userRepository->update(["is_active" => 1], $user->id);
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
