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
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',
            'phone_number' => 'required|string',
            'dob' => 'required|date',
            'image' => 'sometimes|image|mimes:png,jpg,jpeg',
            'id_img' => 'string',
            'gender' => 'required|string|in:male,female'
        ];
    }
}
