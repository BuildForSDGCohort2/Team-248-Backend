<?php

namespace App\Services;

use App\Http\Requests\RetrieveAppliedOffersRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\OfferCollection;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RetrieveAppliedOffersService
{
    const PER_PAGE = 10;
    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function execute(RetrieveAppliedOffersRequest $request)
    {
        try {
            $filters = array();
            $user = $request->user('sanctum');
            if ($request->has('category_id')) {
                array_push($filters, ['category_id', '=', $request->get('category_id')]);
            }

            $userOffers  = $this->offerRepository->getAppliedOffers($user->id, $request->get('status_id'))
                ->findWhere($filters)->paginate(self::PER_PAGE);
            $offer_data = OfferCollection::make($userOffers)->isApplicant(true);

            return $offer_data;
        } catch (Exception $e) {
            Log::info($e);
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
