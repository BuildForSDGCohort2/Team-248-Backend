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
use Illuminate\Support\Facades\Log;

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

            $data = [
                "category_id" => $request->category_id,
                "start_at" => $request->start_at,
                "end_at" => $request->end_at,
                "price_per_hour" => $request->price_per_hour,
                "address" => $request->address,
                "preferred_qualifications" => $request->preferred_qualifications,
                "title" => $request->title,
                "description" => $request->description,
                "exp_from" => $request->exp_from,
                "exp_to" => $request->exp_to,
            ];

            $this->offerRepository->update($data, $offer->id);
            return new SuccessResource(Response::HTTP_OK, "Offer updated successfully.", ["id" => $offer->id]);
        } catch (Exception $e) {

            Log::info($e);
            if ($e instanceof ModelNotFoundException) {
                return new ErrorResource(Response::HTTP_UNPROCESSABLE_ENTITY, "The given data was invalid.", ["category_id" => "Category not found."]);
            }
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
