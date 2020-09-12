<?php

namespace App\Services\Auth;

use \App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
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
        try {
            $user = $this->userRepo->findWhere(['email' => $request->get('email')])->first();
            return $this->handleForgetPasswordEmail($request, $user);
        }catch(\Exception $ex){
            Log::info($ex);
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR,
                __('Failed to send reset password email!'));
        }
    }

    private function handleForgetPasswordEmail(ForgetPasswordRequest $request, $user){
        if ($user) {
            $response = Password::sendResetLink(['email' => $request->get('email')]);
            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return new SuccessResource(Response::HTTP_OK, __('passwords.sent'));

                case Password::INVALID_USER:
                    return new ErrorResource(Response::HTTP_UNPROCESSABLE_ENTITY,
                        trans('passwords.user', ['email' => $request->get('email')]));
            }
        }
        return new ErrorResource(Response::HTTP_UNPROCESSABLE_ENTITY,
            trans('passwords.user', ['email' => $request->get('email')]));
    }
}
