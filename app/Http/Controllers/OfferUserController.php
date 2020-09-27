<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetrieveAppliedOffersRequest;
use App\Services\RetrieveAppliedOffersService;

class OfferUserController extends Controller
{

    /**
     * @param RetrieveAppliedOffersRequest $request
     * @param RetrieveAppliedOffersService $service
     * @return \App\Http\Resources\ErrorResource|\App\Http\Resources\SuccessResource
     */
    public function index(RetrieveAppliedOffersRequest $request, RetrieveAppliedOffersService $service)
    {
        return $service->execute($request);
    }
}
