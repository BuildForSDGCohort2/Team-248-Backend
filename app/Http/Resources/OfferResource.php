<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OfferResource extends JsonResource
{
    /**
     *
     * @var bool
     */
    private $isOwner = false;
    private $isApplicant = false;
    private $applicant_data = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $applicants = $this->applicants;
        return [
            'id'                        => $this->id,
            'category'                  => new OfferCategoryResource($this->category),
            'status'                    => $this->when(Auth::guard('sanctum')->user() && $this->isOwner,
                                            new OfferStatusResource($this->status)),
            'start_at'                  => Carbon::parse($this->start_at)->timestamp,
            'end_at'                    => Carbon::parse($this->end_at)->timestamp,
            'price_per_hour'            => $this->price_per_hour,
            'address'                   => $this->address,
            'preferred_qualifications'  => $this->preferred_qualifications,
            'applicants'                => $this->when(Auth::guard('sanctum')->user() && $this->isOwner,
                                            ApplicantResource::collection($applicants)->setOfferId($this->id)),
            'applications_number'       => count($applicants),
            'applied'                   => $this->isApplicant,
            'application_data'          => $this->when(Auth::guard('sanctum')->user() && $this->isApplicant,
                                            new ApplicationResource($this->applicant_data))

        ];
    }

    public function isOwner($bool = true)
    {
        $this->isOwner = $bool;
        return $this;
    }

    public function isApplicant($applicant_data, $bool = true)
    {
        $this->isApplicant = $bool;
        $this->applicant_data = $applicant_data;
        return $this;
    }
}
