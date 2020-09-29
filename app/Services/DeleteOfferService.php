<?php

namespace App\Services;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Offer;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteOfferService
{
    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function execute(Request $request, Offer $offer)
    {
        try {
            if ($request->user()->id != $offer->user_id) {
                return new ErrorResource(Response::HTTP_FORBIDDEN, "This action is unauthorized.");
            }
            $this->offerRepository->delete($offer->id);
            return new SuccessResource(Response::HTTP_OK, "Offer deleted successfully.");
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
