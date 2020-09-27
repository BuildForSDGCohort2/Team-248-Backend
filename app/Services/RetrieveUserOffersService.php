<?php

namespace App\Services;

use App\Http\Requests\UserOffersRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\SuccessResource;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Http\Response;

class RetrieveUserOffersService
{
    const PER_PAGE = 10;
    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function execute(UserOffersRequest $request)
    {
        try {
            $filters = array();
            $user = $request->user('sanctum');
            array_push($filters, ['user_id', '=', $user->id]);
            if ($request->has('category_id')) {
                array_push($filters, ['category_id', '=', $request->get('category_id')]);
            }
            if ($request->has('status_id')) {
                array_push($filters, ['status_id', '=', $request->get('status_id')]);
            }

            $userOffers  = $this->offerRepository->findWhere($filters)->paginate(self::PER_PAGE);
            $offer_data = OfferCollection::make($userOffers)->isOwner(true);

            return $offer_data;
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
