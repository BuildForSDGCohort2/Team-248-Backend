<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'current_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->isUserPassword()) {
                $validator->errors()->add('current_password', 'Wrong password!');
            }
        });
    }


    private function isUserPassword()
    {
        return (Hash::check($this->input('current_password'), auth()->user()->password));
    }
}
