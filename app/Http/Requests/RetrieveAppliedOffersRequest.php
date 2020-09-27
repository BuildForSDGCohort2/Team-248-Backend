<?php

namespace App\Http\Requests;

class RetrieveAppliedOffersRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

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
            "category_id" => ['nullable', 'integer', 'exists:offer_categories,id'],
            "status_id" => ['nullable', 'integer', 'exists:status,id'],
        ];
    }

}
