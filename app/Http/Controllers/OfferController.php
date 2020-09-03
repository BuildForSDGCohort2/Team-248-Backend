<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Services\CreateOfferService;
use App\Services\UpdateOfferService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request, CreateOfferService $service)
    {
        return $service->execute($request);
    }

    public function update(OfferRequest $request, Offer $offer, UpdateOfferService $service)
    {
        return $service->execute($request, $offer);
    }
}
