<?php

namespace App\Http\Requests;

class OfferRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_id" => "required",
            "category_id" => "required",
            "start_at" => "required|date",
            "end_at" => "required|date|after:start_at",
            "price_per_hour" => "required|numeric|min:1|max:5000",
            "address" => "required|max:500",
            "preferred_qualifications" => "max:500"
        ];
    }
}
