<?php

namespace App\Services;

use App\Http\Requests\OfferRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\OfferRepository;
use App\Repositories\StatusRepository;
use Exception;
use Illuminate\Http\Response;

class CreateOfferService
{
    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function execute(OfferRequest $request)
    {
        $data = $request->all();
        $data = $this->setStatusId($data);
        try {
            $offerId = $this->offerRepository->create($data)->id;
            return new SuccessResource(Response::HTTP_CREATED, "Offer created successfully.", ["id" => $offerId]);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error", ["An unexpected error occured."]);
        }
    }

    protected function setStatusId($data)
    {
        $statusRepository = new StatusRepository();
        $status = $statusRepository->findWhere(["name" => "New"])->first();
        if ($status) {
            $data["status_id"] = $status->id;
            return $data;
        }
        $data["status_id"] = $statusRepository->create(["name" => "New", "description" => "New Offer Status", "code" => "1"])->id;
        return $data;
    }
}
