<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DeactivateAccountService;
use App\Services\User\UserOffersListService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Deactivate a user account
     *
     * Enables the user to deactivate his account
     *
     * @urlParam  user required The ID of the user to be deactivated.
     *
     * @response  200 {
     * "message": "Account deactivated successfully.",
     * "data": ""
     *}
     *
     *
     * @response 401 {
     *  "message": "User Unauthenticated"
     *}
     * @param Request $request
     * @param DeactivateAccountService $service
     * @return \App\Http\Resources\ErrorResource|\App\Http\Resources\SuccessResource
     */
    public function deactivate(Request $request, DeactivateAccountService $service)
    {
        return $service->execute($request);
    }

    /**
     * @param Request $request
     * @param DeactivateAccountService $service
     * @return \App\Http\Resources\ErrorResource|\App\Http\Resources\SuccessResource
     */
    public function offers(Request $request, UserOffersListService $service)
    {
        return $service->execute($request);
    }
}
