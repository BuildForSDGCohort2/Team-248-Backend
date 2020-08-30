<?php

namespace App\Services\Auth;

use \App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\Password;

class ForgetPasswordService
{
    /**
     * @var UserRepository
     */
    private $userRepo = NULL;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function execute(ForgetPasswordRequest $request)
    {
        $user = $this->userRepo->findWhere(['email' => $request->get('email')])->first();

        if ($user) {
            $response = Password::sendResetLink(['email' => $request->get('email')]);
            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return new SuccessResource(Res::HTTP_OK, __('Reset password link sent on your email'));

                case Password::INVALID_USER:
                    return new ErrorResource(Res::HTTP_UNAUTHORIZED,
                        __('The email you have entered is not registered!'));
            }
        } else {
            return new ErrorResource(Res::HTTP_UNAUTHORIZED,
                __('The email you have entered is not registered!'));
        }
    }
}
