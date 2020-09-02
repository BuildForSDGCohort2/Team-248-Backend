<?php

namespace App\Services\User;

use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;

class RegisterUserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            if( $request->hasFile('image')) {
                $imagePath = $request->file('image')->store('profile_pictures','public');
                $data = array_merge($request->validated(), ['image' => $imagePath]);
            }

            $user = $this->userRepository->create($data);

            $token = $user->createToken('authToken')->plainTextToken;
            return new SuccessResource(Response::HTTP_CREATED, "Registred successfully.", [
                'user' => $user,
                'token' => $token
            ]);

        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
