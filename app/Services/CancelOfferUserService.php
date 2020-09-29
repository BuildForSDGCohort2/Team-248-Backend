<?php

namespace App\Services;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Offer;
use App\Models\OfferUser;
use App\Repositories\OfferUserRepository;
use App\Repositories\StatusRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CancelOfferUserService
{
    protected $offerUserRepository;
    protected $statusRepository;

    public function __construct(OfferUserRepository $offerUserRepository, StatusRepository $statusRepository)
    {
        $this->offerUserRepository = $offerUserRepository;
        $this->statusRepository = $statusRepository;
    }

    public function execute(Request $request, OfferUser $application)
    {
        if ($request->user()->id != $application->user_id) {
            return new ErrorResource(Response::HTTP_UNAUTHORIZED, "This action is unauthorized.");
        }

        $data = $this->setStatusId();
        try {
            $this->offerUserRepository->update($data, $application->id);
            return new SuccessResource(Response::HTTP_OK, "Application cancelled successfully.");
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }

    protected function setStatusId()
    {
        $status = $this->statusRepository->findWhere(["code" => "cancelled"])->first();
        if ($status) {
            $data["status_id"] = $status->id;
            return $data;
        }
        $data["status_id"] = $this->statusRepository->create(["name" => "Cancelled", "description" => "Request has been cancelled", "code" => "cancelled"])->id;
        return $data;
    }
}
