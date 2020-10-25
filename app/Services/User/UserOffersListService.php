<?php

namespace App\Services\User;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\OfferResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserOffersListService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(Request $request)
    {
        try {
            return OfferResource::collection($request->user()->offers);
        } catch (Exception $e) {
            return new ErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error");
        }
    }
}
