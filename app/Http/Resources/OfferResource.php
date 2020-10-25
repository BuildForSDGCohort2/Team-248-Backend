<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OfferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'category'                  => new OfferCategoryResource($this->category),
            'status'                    => new OfferStatusResource($this->status),
            'start_at'                  => $this->start_at,
            'end_at'                    => $this->end_at,
            'price_per_hour'            => $this->price_per_hour,
            'address'                   => $this->address,
            'preferred_qualifications'  => $this->preferred_qualifications,
            'title'                     => $this->title,
            'description'               => $this->description,
            'exp_from'                  => $this->exp_from,
            'exp_to'                    => $this->exp_to,
            'user_id'                   => $this->user_id,
        ];
    }
}

