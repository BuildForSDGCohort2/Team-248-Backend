<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use \App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Services\Auth\ForgetPasswordService;

class ForgetPasswordController extends Controller
{
    public function index(ForgetPasswordRequest $request, ForgetPasswordService $service)
    {
        return $service->execute($request);
    }
}
