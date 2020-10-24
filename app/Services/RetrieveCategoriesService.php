<?php

namespace App\Services;

use App\Http\Resources\OfferCategoryResource;
use App\Repositories\OfferCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Resources\ErrorResource;
use App\Models\Offer;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RetrieveCategoriesService
{
    protected $repository;

    public function __construct(OfferCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ErrorResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function execute()
    {
        try {
            $offerCategories = $this->repository->all();
            return OfferCategoryResource::collection($offerCategories);
        } catch (Exception $e) {
            Log::info($e);
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, __("Internal Server Error"));
        }
    }
}
