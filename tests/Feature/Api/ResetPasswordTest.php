<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Password;
use Tests\TestCase;
use Illuminate\Http\Response;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    const ROUTE_Reset_PASSWORD = 'password.reset';

    const USER_PASSWORD = 'Password@123';
    const USER_NEW_PASSWORD = 'Newpass@123';

    /** @test */
    public function testSubmitResetPasswordInvalidEmail()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD),
        ]);

        $token = Password::broker()->createToken($user);

        $this
            ->post(route(self::ROUTE_Reset_PASSWORD), [
                'token' => $token,
                'email' => "testtest",
                'password' => self::USER_NEW_PASSWORD,
                'password_confirmation' => self::USER_NEW_PASSWORD,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee(__('validation.email', [
                'attribute' => 'email',
            ]));
    }

    /** @test */
    public function testSubmitPasswordResetEmailNotFound()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD),
        ]);

        $token = Password::broker()->createToken($user);

        $this
            ->post(route(self::ROUTE_Reset_PASSWORD), [
                'token' => $token,
                'email' => $this->faker->unique()->safeEmail,
                'password' => self::USER_NEW_PASSWORD,
                'password_confirmation' => self::USER_NEW_PASSWORD,
            ])->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonFragment(['message' => __('passwords.token')]);
    }

    /** @test */
    public function testSubmitResetPasswordPasswordMismatch()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD),
        ]);

        $token = Password::broker()->createToken($user);

        $password_confirmation = "Hello@123";

        $this
            ->post(route(self::ROUTE_Reset_PASSWORD), [
                'token' => $token,
                'email' => $user->email,
                'password' => self::USER_NEW_PASSWORD,
                'password_confirmation' => $password_confirmation,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee(__('validation.confirmed', [
                'attribute' => 'password',
            ]));
    }

    /** @test */
    public function testSubmitResetPasswordPasswordTooShort()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD),
        ]);

        $token = Password::broker()->createToken($user);

        $password ="12345";

        $this
            ->post(route(self::ROUTE_Reset_PASSWORD), [
                'token' => $token,
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee(__('validation.min.string', [
                'attribute' => 'password',
                'min' => 6,
            ]));
    }

    /** @test */
    public function testSubmitResetPasswordSuccess()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD),
        ]);

        $token = Password::broker()->createToken($user);

        $this
            ->post(route(self::ROUTE_Reset_PASSWORD), [
                'token' => $token,
                'email' => $user->email,
                'password' => self::USER_NEW_PASSWORD,
                'password_confirmation' => self::USER_NEW_PASSWORD,
            ])->assertSuccessful()
            ->assertSee(__('Your password changed successfully'));
    }
}
