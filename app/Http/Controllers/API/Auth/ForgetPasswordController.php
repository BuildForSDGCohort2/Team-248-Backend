<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use \App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Services\Auth\ForgetPasswordService;

class ForgetPasswordController extends Controller
{
    public function __invoke(ForgetPasswordRequest $request, ForgetPasswordService $service)
    {
        return $service->execute($request);
    }
}
