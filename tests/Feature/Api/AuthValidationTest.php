<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthValidationTest extends TestCase
{
    use RefreshDatabase;

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
            'profile_img' => $file,
            'id_img' => $file,
        ];

        $response = $this->postJson(route('api.register'), array_merge($userData, $attributes));

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["profile_img", "id_img"]);

        // Assert the file was stored...
        Storage::disk('public')->assertMissing("img/profiles/" . $file->hashName());
        Storage::disk('public')->assertMissing("img/id/" . $file->hashName());
    }
}
