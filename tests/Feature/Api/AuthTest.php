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

        $file = UploadedFile::fake()->image('pofile.jpg');

        $userData = factory('App\Models\User')->make()->toArray();

        $attributes = [
            'password' => 'UPPER&&lower&&1234',
            'password_confirmation' => 'UPPER&&lower&&1234',
            'image' => $file
        ];

        $this->post(route('api.register'), array_merge($userData, $attributes))->assertJsonStructure(['data' => ['user', 'token']]);

        // Assert the file was stored...
        Storage::disk('public')->assertExists("profile_pictures/" . $file->hashName());
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
