<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

/**
 * Description of ForgetPasswordRequest
 *
 * @author Nourhan
 */
class ForgetPasswordRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

}
