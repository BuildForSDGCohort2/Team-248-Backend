<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $userData = factory('App\Models\User')->make()->toArray();
        $password = [
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $this->post(route('api.register'), array_merge($userData, $password))->assertJsonStructure(['user', 'token']);
    }

    /** @test */
    public function user_can_logout()
    {
        $user = factory('App\Models\User')->create();

        Sanctum::actingAs($user, ['authToken']);

        $this->post(route('api.logout'))->assertSee('Token deleted');
    }

    /** @test */
    public function can_get_user_data_by_token()
    {
        $user = factory('App\Models\User')->create();

        Sanctum::actingAs($user, ['authToken']);

        $this->get(route('api.getUser'))->assertJsonStructure(['user' => ['name', 'email']]);
    }
}
