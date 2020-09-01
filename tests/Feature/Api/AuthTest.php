<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_login()
    {
        $user = factory('App\Models\User')->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'password'
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
            'password' => 'password',
            'password_confirmation' => 'password',
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
