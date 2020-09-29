<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Hashing\Hasher;

class ResetPasswordService
{
    /**
     * @var UserRepository
     */
    private $userRepo = NULL;

    /**
     * @var Hasher
     */
    private $hasher = NULL;

    public function __construct(UserRepository $userRepo,
                                PasswordResetRepository $passwordResetRepo, Hasher $hasher)
    {
        $this->userRepo = $userRepo;
        $this->passwordResetRepo = $passwordResetRepo;
        $this->hasher = $hasher;
    }

    /**
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function execute(ResetPasswordRequest $request)
    {
        try {
            if ($this->is_valid_token($request)) {
                $user = $this->userRepo->findWhere(['email' => $request->get('email')])->first();
                if($user) {
                    $this->userRepo->update(['password' => bcrypt($request->get('password'))], $user->id);
                    return new SuccessResource(Response::HTTP_OK,
                        __('Your password changed successfully'));
                }
            }
            return new ErrorResource(Response::HTTP_UNAUTHORIZED,
                __('passwords.token'));
        }catch(\Exception $ex){
            Log::info($ex);
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR,
                __("Internal Server Error"));
        }
    }

    public function is_valid_token($request)
    {
        $resetPassword = $this->passwordResetRepo
            ->findWhere(['email' => $request->get('email')])->first();

        if (!$resetPassword){
            return false;
        }
        if ($this->tokenExpired($resetPassword->created_at)
            || !$this->hasher->check($request->get('token'), $resetPassword->token)) {
            $this->passwordResetRepo
                ->deleteWhere(['email' => $request->get('email')]);
            return false;
        }
        $this->passwordResetRepo
            ->deleteWhere(['email' => $request->get('email')]);
        return true;
    }

    /**
     * Determine if the token has expired.
     *
     * @param  string  $createdAt
     * @return bool
     */
    protected function tokenExpired($created_at)
    {
        return Carbon::parse($created_at)
            ->addSeconds(config('auth.passwords.'.config('auth.defaults.passwords').'.expire') * 60)->isPast();
    }
}
