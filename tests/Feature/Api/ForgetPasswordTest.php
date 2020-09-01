<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Notification;
use Tests\TestCase;
use Illuminate\Http\Response;

class ForgetPasswordTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    const ROUTE_FORGET_PASSWORD = 'forget.password';

    /** @test */
    public function testSubmitForgetPasswordRequestInvalidEmail()
    {
        $this
            ->followingRedirects()
            ->post(route(self::ROUTE_FORGET_PASSWORD), [
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
        $this
            ->followingRedirects()
            ->post(route(self::ROUTE_FORGET_PASSWORD), [
                'email' => $this->faker->unique()->safeEmail,
            ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonFragment(['message' => __('passwords.user')]);
    }

    /** @test */
    public function testSubmitForgetPasswordRequestSuccess()
    {
        $user = factory(User::class)->create();

        $this
            ->followingRedirects()
            ->post(route(self::ROUTE_FORGET_PASSWORD), [
                'email' => $user->email,
            ])
            ->assertSuccessful()
            ->assertSee(__('passwords.sent'));

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
