<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class OfferCollection extends ResourceCollection
{

    /**
     *
     * @var bool
     */
    private $isOwner = false;
    private $isApplicant = false;
    private $applicant_data = null;

    public function isOwner($bool = true)
    {
        $this->isOwner = $bool;
        return $this;
    }

    public function isApplicant($bool = true)
    {
        $this->isApplicant = $bool;
        return $this;
    }

    public function setApplicantData($applicant_data){
        $this->applicant_data = $applicant_data;
        return $this;
    }

    public function toArray($request)
    {
        return
            [
                'data'  =>
                    $this->collection->map(function (Offer $resource) use ($request) {
                        if($this->isApplicant){
                            return $resource->isApplicant($this->isApplicant)
                                ->setApplicantData($this->applicant_data)->toArray($request);
                        }
                        return $resource->isOwner($this->isOwner)->toArray($request);
                    })->all(),
                'pagination' => Arr::except($this->resource->toArray(), 'data'),
        ];
    }
}

