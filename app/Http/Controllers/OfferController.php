<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Http\Requests\UserOffersRequest;
use App\Services\OfferService;
use App\Services\RetrieveUserOffersService;

class OfferController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request, OfferService $service)
    {
        return $service->execute($request);
    }

    /**
     * @param UserOffersRequest $request
     * @param RetrieveUserOffersService $service
     * @return \App\Http\Resources\ErrorResource|\App\Http\Resources\SuccessResource
     */
    public function userOffers(UserOffersRequest $request, RetrieveUserOffersService $service)
    {
        return $service->execute($request);
    }
}
