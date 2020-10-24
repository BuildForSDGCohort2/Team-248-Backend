<?php

namespace App\Services;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Offer;
use App\Repositories\OfferUserRepository;
use App\Repositories\StatusRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateOfferUserService
{
    protected $offerUserRepository;
    protected $statusRepository;

    public function __construct(OfferUserRepository $offerUserRepository, StatusRepository $statusRepository)
    {
        $this->offerUserRepository = $offerUserRepository;
        $this->statusRepository = $statusRepository;
    }

    public function execute(Request $request, Offer $offer)
    {
        $status = $this->statusRepository->findWhere(["id" => $offer->status_id])->first();
        if ($status->code == "approved") {
            return new ErrorResource(Response::HTTP_UNPROCESSABLE_ENTITY, "This offer has already been approved.");
        }

        $data = [
            "user_id" => $request->user()->id,
            "offer_id" => $offer->id
        ];
        $data = $this->setStatusId($data);
        try {
            $applicationId = $this->offerUserRepository->create($data)->id;
            return new SuccessResource(Response::HTTP_CREATED, "Application created successfully.", ["id" => $applicationId]);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }

    protected function setStatusId($data)
    {
        $status = $this->statusRepository->findWhere(["code" => "new"])->first();
        if ($status) {
            $data["status_id"] = $status->id;
            return $data;
        }
        $data["status_id"] = $this->statusRepository->create(["name" => "New", "description" => "New Offer Status", "code" => "new"])->id;
        return $data;
    }
}
