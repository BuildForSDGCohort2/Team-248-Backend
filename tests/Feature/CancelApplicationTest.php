<?php

namespace Tests\Feature;

use App\Models\OfferUser;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CancelApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function testCancelApplicationSuccess()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $application = factory(OfferUser::class)->create(["user_id" => $user->id]);
        $status = factory(Status::class)->create(["code" => "cancelled"]);
        $response = $this->patch("/api/applications/$application->id/cancel");

        $response->assertStatus(200);
        $response->assertJson(["message" => "Application cancelled successfully."]);
        $this->assertDatabaseHas("offer_users", ["id" => $application->id, "status_id" => $status->id]);
    }

    public function testCancelApplicationUnauthenticated()
    {
        $user = factory(User::class)->create();
        $application = factory(OfferUser::class)->create(["user_id" => $user->id]);
        $response = $this->withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->patch("/api/applications/$application->id/cancel");

        $response->assertStatus(401);
        $response->assertJson(["message" => "Unauthenticated."]);
    }

    public function testCancelApplicationUnauthorized()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        Sanctum::actingAs($user);


        $application = factory(OfferUser::class)->create(["user_id" => $user2->id]);
        $response = $this->withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->patch("/api/applications/$application->id/cancel");

        $response->assertStatus(401);
        $response->assertJson(["data"=>["message" => "This action is unauthorized."]]);
    }
}
