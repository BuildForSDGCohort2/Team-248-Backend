<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\OfferUser;
use App\Services\CancelOfferUserService;
use App\Services\CreateOfferUserService;
use Illuminate\Http\Request;

class OfferUserController extends Controller
{
    /**
     * Create an offer
     *
     * Enables the user to create a new offer
     * 
     * @bodyParam  category_id integer required the id of the offer category.
     * @bodyParam  start_at datetime required the start date and time of the offer.
     * @bodyParam  end_at datetime required the end date and time of the offer.
     * @bodyParam  price_per_hour float required the price per hour offered.
     * @bodyParam  address string required the address where the offer takes place.
     * @bodyParam  preferred_qualifications string optional the address where the offer takes place.
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

    public function cancel(Request $request, OfferUser $application, CancelOfferUserService $service)
    {
        return $service->execute($request, $application);
    }
}
