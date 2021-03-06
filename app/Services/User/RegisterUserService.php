<?php

namespace App\Services\User;

use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;

class RegisterUserService
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

    public function execute(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('profile_img')) {
                $profile_img = $request->file('profile_img')->store('img/profiles', 'public');
                $data = array_merge($data, ['profile_img' => $profile_img]);
            }

            if ($request->hasFile('id_img')) {
                $id_img = $request->file('id_img')->store('img/id', 'public');
                $data = array_merge($data, ['id_img' => $id_img]);
            }

            $user = $this->userRepository->create($data);
            $token = $this->jwt->attempt(['email' => $request->input('email'),'password' => $request->input('password')]);

            return new SuccessResource(Response::HTTP_CREATED, "Registered successfully.", [
                'user' => new UserResource($user),
                'token' => $token
            ]);

        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
