<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'offer_id'              => $this->offer_id,
            'user_id'               => $this->user_id,
            'status'                => new OfferStatusResource($this->status),
            'created_at'           => $this->created_at->timestamp,
        ];
    }

}
