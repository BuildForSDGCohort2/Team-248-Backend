<?php

namespace App\Services;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\OfferResource;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
            $offers = $this->offerRepository->getNewOffers($userId, $request->query("category_id"))
                ->paginate($count);
            return OfferResource::collection($offers);
        } catch (Exception $e) {
            Log::info($e);
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
