<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;

class ResetPasswordController extends Controller
{
    /**
     * @param ResetPasswordRequest $request
     * @param ResetPasswordService $service
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function __invoke(ResetPasswordRequest $request, ResetPasswordService $service)
    {
        return $service->execute($request);
    }
}
