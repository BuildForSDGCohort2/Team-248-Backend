<?php

namespace App\Services;

use App\Http\Requests\OfferRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Offer;
use App\Repositories\OfferRepository;
use App\Repositories\StatusRepository;
use Exception;
use Illuminate\Http\Response;

class UpdateOfferService
{
    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function execute(OfferRequest $request, Offer $offer)
    {
        try {
            $offer->category_id = $request->category_id;
            $offer->start_at = $request->start_at;
            $offer->end_at = $request->end_at;
            $offer->price_per_hour = $request->price_per_hour;
            $offer->address = $request->address;
            $offer->preferred_qualifications = $request->preferred_qualifications;
            $offer->save();
            return new SuccessResource(Response::HTTP_OK, "Offer updated successfully.", ["id" => $offer->id]);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
