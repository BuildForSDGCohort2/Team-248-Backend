<?php

namespace Tests\Feature;

use App\Models\OfferUser;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancelApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function testCancelApplicationSuccess()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $application = factory(OfferUser::class)->create(["user_id" => $user->id]);
        $status = factory(Status::class)->create(["code" => "cancelled"]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->patch("/api/applications/$application->id/cancel");

        $response->assertStatus(200);
        $response->assertJson(["message" => "Application cancelled successfully."]);
        $this->assertDatabaseHas("offer_users", ["id" => $application->id, "status_id" => $status->id]);
    }

    public function testCancelApplicationUnauthenticated()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $application = factory(OfferUser::class)->create(["user_id" => $user->id]);
        $response = $this->withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->patch("/api/applications/$application->id/cancel");

        $response->assertStatus(401);
        $response->assertJson(["data" => ["message" => "User Unauthenticated"]]);
    }

    public function testCancelApplicationUnauthorized()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $user2 = factory(User::class)->create();
        $token = $this->userAuthToken($user);


        $application = factory(OfferUser::class)->create(["user_id" => $user2->id]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->patch("/api/applications/$application->id/cancel");

        $response->assertStatus(401);
        $response->assertJson(["data"=>["message" => "This action is unauthorized."]]);
    }
}
