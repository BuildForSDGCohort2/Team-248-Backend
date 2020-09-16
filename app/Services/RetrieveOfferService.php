<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\SuccessResource;
use App\Models\Offer;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RetrieveOfferService
{
    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @param Request $request
     * @param Offer $offer
     * @return ErrorResource|SuccessResource
     */
    public function execute(Request $request, Offer $offer)
    {
        try {
            $user = $request->user('sanctum');
            $application = $offer->offer_users()->where('offer_user.user_id', $user->id)->first();
            $request->merge(['offer_id' => $offer->id]); //for padding offer id into the request to the resources
            $offer_data = new OfferResource($offer);
            if($user){
                if($user->id == $offer->user_id){ // user is the owner of the offer
                    $offer_data = (new OfferResource($offer))->isOwner();
                } else if($application){ //user applied for this offer
                    $offer_data = (new OfferResource($offer))->isApplicant($application);
                }
            }
            return new SuccessResource(Response::HTTP_OK, __("Offer retrieved successfully."), $offer_data);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, __("Internal Server Error"));
        }
    }
}
