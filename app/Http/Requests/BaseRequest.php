<?php

namespace App\Http\Requests;

use App\Http\Resources\ErrorResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

/**
 * Description of BaseRequest
 *
 * @author Nourhan
 */
class BaseRequest extends FormRequest
{
    protected $nameRules;
    protected $descriptionRules;
    public function __construct()
    {
        $this->nameRules = 'required|string|between:2,50';
        $this->descriptionRules = 'required|string|between:2,200';
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json(new ErrorResource(Response::HTTP_FORBIDDEN, "This action is unauthorized."), 403));
    }
}
