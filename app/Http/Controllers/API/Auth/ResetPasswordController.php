<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use \App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\ErrorResource;
use App\Services\Auth\ForgetPasswordService;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    /**
     * @param ResetPasswordRequest $request
     * @param ResetPasswordService $service
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(ResetPasswordRequest $request, ResetPasswordService $service)
    {
        return $service->execute($request);
    }
}
