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

    /** @test */
    public function cannot_register_without_required_attributes()
    {
        $response = $this->postJson(route('api.register'), []);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["name", "password", "email", "phone_number", "dob", "gender"]);
    }

    /** @test */
    public function cannot_register_with_wrong_email()
    {
        $userData = factory('App\Models\User')->make(['email' => 'wrong-email'])->toArray();

        $attributes = [
            'password' => 'UPPER&&lower&&1234',
            'password_confirmation' => 'UPPER&&lower&&1234',
        ];

        $response = $this->postJson(route('api.register'), array_merge($userData, $attributes));

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["email"]);
    }

    /** @test */
    public function cannot_register_with_an_existing_email()
    {
        factory('App\Models\User')->create(['email' => 'email@already.exists']);
        $userData = factory('App\Models\User')->make(['email' => 'email@already.exists'])->toArray();

        $attributes = [
            'password' => 'UPPER&&lower&&1234',
            'password_confirmation' => 'UPPER&&lower&&1234',
        ];

        $response = $this->postJson(route('api.register'), array_merge($userData, $attributes));

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["email"]);
    }

    /** @test */
    public function cannot_register_with_a_simple_password()
    {
        $userData = factory('App\Models\User')->make()->toArray();

        $attributes = [
            'password' => 'simple_password',
            'password_confirmation' => 'simple_password',
        ];

        $response = $this->postJson(route('api.register'), array_merge($userData, $attributes));

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["password"]);
    }

    /** @test */
    public function cannot_register_with_uncomfirmed_password()
    {
        $userData = factory('App\Models\User')->make()->toArray();

        $attributes = [
            'password' => 'UPPER&&lower&&1234',
            'password_confirmation' => 'UPPER&&lower&&12',
        ];

        $response = $this->postJson(route('api.register'), array_merge($userData, $attributes));

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["password"]);
    }

    /** @test */
    public function cannot_register_with_wrong_format_of_date_dob()
    {
        $userData = factory('App\Models\User')->make(['dob' => 'wrong_date_format'])->toArray();

        $attributes = [
            'password' => 'UPPER&&lower&&1234',
            'password_confirmation' => 'UPPER&&lower&&1234',
        ];

        $response = $this->postJson(route('api.register'), array_merge($userData, $attributes));

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["dob"]);
    }

    /** @test */
    public function cannot_upload_wrong_format_of_prfile_picture_while_register()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 150 , 'application/pdf');

        $userData = factory('App\Models\User')->make()->toArray();

        $attributes = [
            'password' => 'UPPER&&lower&&1234',
            'password_confirmation' => 'UPPER&&lower&&1234',
            'image' => $file
        ];

        $response = $this->postJson(route('api.register'), array_merge($userData, $attributes));

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["image"]);

        // Assert the file was stored...
        Storage::disk('public')->assertMissing("profile_pictures/" . $file->hashName());
    }
}
