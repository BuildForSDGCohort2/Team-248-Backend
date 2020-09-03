<?php

namespace App\Services;

use App\Http\Requests\OfferRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Offer;
use App\Repositories\OfferCategoryRepository;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class UpdateOfferService
{
    protected $offerRepository;
    protected $categoryRepository;

    public function __construct(OfferRepository $offerRepository, OfferCategoryRepository $categoryRepository)
    {
        $this->offerRepository = $offerRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(OfferRequest $request, Offer $offer)
    {
        try {
            $this->categoryRepository->findOrFail($request->category_id);

            $offer->category_id = $request->category_id;
            $offer->start_at = $request->start_at;
            $offer->end_at = $request->end_at;
            $offer->price_per_hour = $request->price_per_hour;
            $offer->address = $request->address;
            $offer->preferred_qualifications = $request->preferred_qualifications;
            $offer->save();
            return new SuccessResource(Response::HTTP_OK, "Offer updated successfully.", ["id" => $offer->id]);
        } catch (Exception $e) {

            if ($e instanceof ModelNotFoundException) {
                return new ErrorResource(Response::HTTP_UNPROCESSABLE_ENTITY, "The given data was invalid.", ["category_id" => "Category not found."]);
            }
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
