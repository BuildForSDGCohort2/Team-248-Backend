<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Services\OfferService;
use App\Services\ViewOffersService;
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

    public function index(Request $request, ViewOffersService $service)
    {
        return $service->execute($request);
    }
}
