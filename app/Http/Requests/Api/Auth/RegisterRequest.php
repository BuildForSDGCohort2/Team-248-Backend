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
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'dob' => 'required|date|max:255',
            'profile_img' => 'sometimes|image|mimes:png,jpg,jpeg',
            'id_img' => 'sometimes|image|mimes:png,jpg,jpeg',
            'gender' => 'required|string|in:male,female'
        ];
    }
}
