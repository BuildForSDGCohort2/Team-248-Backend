<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_password()
    {
        $user = factory('App\Models\User')->create(['password' => 'Test@123']);;

        $token = $this->userAuthToken($user);

        $passwordData = [
            'current_password' => 'Test@123',
            'password' => 'NEW&&password@@1234',
            'password_confirmation' => 'NEW&&password@@1234',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', route('api.profile.updatePassword'), $passwordData);
        $response->assertSuccessful();
    }

    /** @test */
    public function user_cannot_update_password_without_required_attributes()
    {
        $user = factory('App\Models\User')->create(['password' => 'Test@123']);;

        $token = $this->userAuthToken($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->putJson(route('api.profile.updatePassword'));

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["current_password", "password"]);
    }

    /** @test */
    public function user_cannot_update_password_without_a_valid_current_password()
    {
        $user = factory('App\Models\User')->create(['password' => 'Test@123']);;

        $token = $this->userAuthToken($user);

        $passwordData = [
            'current_password' => 'NEW&&password@@1234',
            'password' => 'NEW&&password@@1234',
            'password_confirmation' => 'NEW&&password@@1234',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', route('api.profile.updatePassword'), $passwordData);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["current_password"]);
        $this->assertTrue(!Hash::check($passwordData['password'], $user->password));
    }
}
