<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $application = $this->offer_users()->where('offer_id', $request->get('offer_id'))->first();
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'phone_number'          => $this->phone_number,
            'profile_img'           => $this->profile_img,
            'gender'                => $this->gender,
            'application_data'      => new ApplicationResource($application),
        ];
    }

}
