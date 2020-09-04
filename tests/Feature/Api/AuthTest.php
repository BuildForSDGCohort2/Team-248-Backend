<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login()
    {
        $user = factory('App\Models\User')->create(['password' => 'UPPER&&lower&&1234']);
        $credentials = [
            'email' => $user->email,
            'password' => 'UPPER&&lower&&1234'
        ];

        $this->post(route('api.login'), $credentials)->assertJsonStructure(['data' => ['user', 'token']]);
    }

    /** @test */
    public function user_can_register()
    {
        Storage::fake('public');

        $profileImage = UploadedFile::fake()->image('profile.jpg');
        $idImage = UploadedFile::fake()->image('id.jpg');


        $passwords = [
            'password' => 'UPPER&&lower&&1234',
            'password_confirmation' => 'UPPER&&lower&&1234'
        ];

        $attributes = [
            'profile_img' => $profileImage,
            'id_img' => $idImage
        ];

        $userData = factory('App\Models\User')->make($attributes)->toArray();

        $this->postJson(route('api.register'), array_merge($userData, $passwords))->assertJsonStructure(['data' => ['user', 'token']]);


        // Assert the file was stored...
        Storage::disk('public')->assertExists("img/profiles/" . $profileImage-> hashName());
        Storage::disk('public')->assertExists("img/id/" . $idImage-> hashName());
    }

    /** @test */
    public function user_can_logout()
    {
        $user = factory('App\Models\User')->create();

        Sanctum::actingAs($user, ['authToken']);

        $this->post(route('api.logout'))->assertSee('Logged out successfully.');
    }

    /** @test */
    public function can_get_user_data_by_token()
    {
        $user = factory('App\Models\User')->create();

        Sanctum::actingAs($user, ['authToken']);

        $this->get(route('api.getUser'))->assertJsonStructure(['data' => ['user' => ['name', 'email']]]);
    }
}
