<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Notification;
use Tests\TestCase;
use Illuminate\Http\Response;

class ForgetPasswordTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    const ROUTE_FORGET_PASSWORD = '/api/forget-password';

    /** @test */
    public function testSubmitForgetPasswordRequestInvalidEmail()
    {
        $this
            ->followingRedirects()
            ->post(self::ROUTE_FORGET_PASSWORD, [
                'email' => 'invalid_email',
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee(__('validation.email', [
                'attribute' => 'email',
            ]));
    }

    /** @test */
    public function testSubmitForgetPasswordRequestEmailNotFound()
    {
        $email = $this->faker->unique()->safeEmail;
        $response = $this->post(self::ROUTE_FORGET_PASSWORD, [
                'email' => $email,
            ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' =>
                trans('passwords.user', ['email' => $email])]);
    }

    /** @test */
    public function testSubmitForgetPasswordRequestSuccess()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);

        $response = $this->post(self::ROUTE_FORGET_PASSWORD, [
                'email' => $user->email,
            ]);
        $response->assertSuccessful();
        $response->assertSee(__('passwords.sent'));

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
