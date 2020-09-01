<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use \App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Resources\ErrorResource;
use App\Services\Auth\ForgetPasswordService;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\Log;

class ForgetPasswordController extends Controller
{
    public function index(ForgetPasswordRequest $request, ForgetPasswordService $service)
    {
        try {
            return $service->execute($request);
        }catch(\Exception $ex){
            Log::info($ex);
            return new ErrorResource(Res::HTTP_BAD_REQUEST,
                __('Failed to send reset password email!'));
        }
    }
}
