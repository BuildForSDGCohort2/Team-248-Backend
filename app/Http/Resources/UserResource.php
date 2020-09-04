<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'dob' => $this->dob,
            'profile_img' => (string) $this->profile_img,
            'id_img' => (string) $this->id_img,
            'gender' => $this->gender,
            'is_active' => $this->is_active,
        ];
    }
}
