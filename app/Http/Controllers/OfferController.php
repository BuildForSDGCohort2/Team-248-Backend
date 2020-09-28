<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Http\Resources\ErrorResource;
use App\Models\Offer;
use App\Services\CreateOfferService;
use App\Services\UpdateOfferService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\RetrieveUserOffersService;
use App\Http\Requests\UserOffersRequest;

class OfferController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
     * @response  200 {
     * "message": "Offer created successfully.",
     *  "data": {
     *      "id": 51
     *  }
     * }
     *
     * @response 422 {
     *   "message": "The given data was invalid.",
     *  "errors": {
     *     "user_id": [
     *        "The user id field is required."
     *   ],
     *  "category_id": [
     *     "The category id field is required."
     *],
     *      "start_at": [
     *         "The start at field is required."
     *    ],
     *   "end_at": [
     *      "The end at field is required."
     * ],
     *"price_per_hour": [
     *   "The price per hour field is required."
     *      ],
     *     "address": [
     *        "The address field is required."
     *   ]
     *}
     *}
     *
     */
    public function store(OfferRequest $request, CreateOfferService $service)
    {
        return $service->execute($request);
    }

    /**
     * Update an offer
     *
     * Enables the user to update an existing offer
     * 
     * @urlParam  id required The ID of the offer.
     * @bodyParam  category_id integer required the id of the offer category.
     * @bodyParam  start_at datetime required the start date and time of the offer.
     * @bodyParam  end_at datetime required the end date and time of the offer.
     * @bodyParam  price_per_hour float required the price per hour offered.
     * @bodyParam  address string required the address where the offer takes place.
     * @bodyParam  preferred_qualifications string optional the address where the offer takes place.
     * 
     * @response  200 {
     *  "message": "Offer updated successfully.",
     *  "data": {
     *     "id": 2
     *   }
     *}
     *
     * @response 422 {
     *   "message": "The given data was invalid.",
     *  "errors": {
     *     "user_id": [
     *        "The user id field is required."
     *   ],
     *  "category_id": [
     *     "The category id field is required."
     *],
     *      "start_at": [
     *         "The start at field is required."
     *    ],
     *   "end_at": [
     *      "The end at field is required."
     * ],
     *"price_per_hour": [
     *   "The price per hour field is required."
     *      ],
     *     "address": [
     *        "The address field is required."
     *   ]
     *}
     *}
     *
     * @response 404 {
     *  "message": "Resource not found.",
     *   "errors": ""
     *}
     *
     */
    public function update(OfferRequest $request, Offer $offer, UpdateOfferService $service)
    {
        return $service->execute($request, $offer);
    }

    /**
     * @param UserOffersRequest $request
     * @param RetrieveUserOffersService $service
     * @return \App\Http\Resources\ErrorResource|\App\Http\Resources\SuccessResource
     */
    public function userOffers(UserOffersRequest $request, RetrieveUserOffersService $service)
    {
        return $service->execute($request);
    }
}
