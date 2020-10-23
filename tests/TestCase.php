<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Log;
use Notification;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    public function userAuthToken($user){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->json('POST',route('api.login'),[
            'email' => $user->email,
            'password' => 'Test@123',
        ]);
        return $response['data']['token'];
    }
}
