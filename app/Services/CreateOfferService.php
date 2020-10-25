<?php

namespace App\Services;

use App\Http\Requests\OfferRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\OfferRepository;
use App\Repositories\StatusRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $data["user_id"] = $request->user()->id;
        try {
            // change start_at and end_at to the default format for date in mysql, to prevent exceptions.
            $data['start_at'] = Carbon::parse($data['start_at'])->format('Y-m-d');
            $data['end_at'] = Carbon::parse($data['end_at'])->format('Y-m-d');
            $offerId = $this->offerRepository->create($data)->id;
            return new SuccessResource(Response::HTTP_CREATED, "Offer created successfully.",
                ["id" => $offerId]);
        } catch (Exception $e) {
            Log::info($e);
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR,
                "Internal Server Error", ["An unexpected error occured."]);
        }
    }

    protected function setStatusId($data)
    {
        $statusRepository = new StatusRepository();
        $status = $statusRepository->findWhere(["code" => "new"])->first();
        if ($status) {
            $data["status_id"] = $status->id;
            return $data;
        }
        $data["status_id"] = $statusRepository->create(
            ["name" => "New", "description" => "New Offer Status", "code" => "new"]
        )->id;
        return $data;
    }
}
