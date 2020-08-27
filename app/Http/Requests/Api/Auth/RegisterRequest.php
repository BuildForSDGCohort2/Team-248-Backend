<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'string',
            'dob' => 'date',
            'profile_img' => 'string',
            'id_img' => 'string',
            'gender' => 'string',
            'is_active' => 'boolean'
        ];
    }
}
