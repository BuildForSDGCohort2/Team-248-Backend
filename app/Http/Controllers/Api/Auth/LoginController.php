<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !$this->checkPassword($request->input('password'), $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 200);
    }

    private function checkPassword($plainText, $hashedText)
    {
        return Hash::check($plainText, $hashedText);
    }
}
