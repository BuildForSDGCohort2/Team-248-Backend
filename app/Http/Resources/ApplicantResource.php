<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    protected $offer_id;

    public function setOfferId($offer_id){
        $this->offer_id = $offer_id;
        return $this;
    }


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request){
        $application = $this->offerUsers()->where('offer_id', $$this->offer_id)->first();
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

    public static function collection($resource){
        return new ApplicantCollection($resource);
    }

}
