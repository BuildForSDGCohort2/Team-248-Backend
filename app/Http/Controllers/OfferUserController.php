<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\OfferUser;
use App\Services\CancelOfferUserService;
use App\Services\CreateOfferUserService;
use Illuminate\Http\Request;
use App\Http\Requests\RetrieveAppliedOffersRequest;
use App\Services\RetrieveAppliedOffersService;

class OfferUserController extends Controller
{

    /**
     * @param RetrieveAppliedOffersRequest $request
     * @param RetrieveAppliedOffersService $service
     * @return \App\Http\Resources\ErrorResource|\App\Http\Resources\SuccessResource
     */
    public function index(RetrieveAppliedOffersRequest $request, RetrieveAppliedOffersService $service)
    {
        return $service->execute($request);
    }
    
    /**
     * Create an offer application
     *
     * Enables the user to apply an offer
     * 
     * 
     * @response  201 {
     *    "message": "Application created successfully.",
     *   "data": {
     *      "id": 1
     * }
     *}
     *
     * @response 404 {
     *  "message": "Resource not found.",
     *   "errors": ""
     *}

     * @response 422 {
     *"data": {
     *     "message": "This offer has already been approved.",
     *      "errors": ""
     *   }
     *}
     *
     */
    public function store(Request $request, Offer $offer, CreateOfferUserService $service)
    {
        return $service->execute($request, $offer);
    }

    /**
     * Cancel an application
     *
     * Enables the user to cancel his application for an offer
     * 
     * 
     * @response  200 {
     *    "message": "Application cancelled successfully.",
     *    "data": ""
     * }
     * 
     * @response 401 {
     *"data": {
     *     "message": "This action is unauthorized.",
     *      "errors": ""
     *   }
     *}
     *
     */
    public function cancel(Request $request, OfferUser $application, CancelOfferUserService $service)
    {
        return $service->execute($request, $application);
    }
}
