<?php

namespace App\Http\Requests;

use App\Http\Resources\ErrorResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class OfferRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user() && $this->offer && $this->user()->id != $this->offer->user_id) {
            return false;
        }
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "category_id" => "required",
            "start_at" => "required|date",
            "end_at" => "required|date|after:start_at",
            "price_per_hour" => "required|numeric|min:1|max:5000",
            "address" => "required|max:500",
            "preferred_qualifications" => "max:500"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $errorResponse = new ErrorResource(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            "The given data was invalid.",
            $errors
        );

        throw new HttpResponseException(
            response()->json($errorResponse, 422)
        );
    }
}
