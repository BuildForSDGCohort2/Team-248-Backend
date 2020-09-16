<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Services\OfferService;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @param Offer $offer
     * @param RetrieveOfferService $service
     * @return \App\Http\Resources\ErrorResource|\App\Http\Resources\SuccessResource
     */
    public function show(Request $request, Offer $offer, RetrieveOfferService $service)
    {
        return $service->execute($request, $offer);
    }
}
