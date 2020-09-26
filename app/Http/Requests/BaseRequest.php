<?php
namespace App\Http\Requests;

use App\Http\Resources\ErrorResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

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

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $errorResponse = new ErrorResource(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            __("The given data was invalid."),
            $errors
        );

        throw new HttpResponseException(
            response()->json($errorResponse, 422)
        );
    }
}
