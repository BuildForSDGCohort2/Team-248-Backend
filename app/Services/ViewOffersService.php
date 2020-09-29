<?php

namespace App\Services;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Offer;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Http\Response;

class ViewOffersService
{
    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function execute($request)
    {
        try {
            $userId = $request->user()->id;
            $paginate = $request->query("paginate");
            $count = null;
            if ($paginate) {
                $count = $paginate;
            }
            $offers = $this->offerRepository->getNewOffers($userId, $request->query("category_id"))->paginate($count);
            return new SuccessResource(Response::HTTP_OK, "Offers fetched successfully.", $offers);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
