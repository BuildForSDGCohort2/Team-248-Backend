<?php

namespace App\Services;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeactivateAccountService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(Request $request, User $user)
    {
        try {
            if ($request->user()->id != $user->id) {
                return new ErrorResource(Response::HTTP_FORBIDDEN, "This action is unathorized.");
            }
            $this->userRepository->update(["is_active" => 0], $user->id);
            $request->user()->currentAccessToken()->delete();
            return new SuccessResource(Response::HTTP_OK, "Account deactivated successfully.");
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error", ["An unexpected error occured."]);
        }
    }
}