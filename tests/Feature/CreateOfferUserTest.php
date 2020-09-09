<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateOfferUserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOfferUserSuccess()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $offer = factory(Offer::class)->create();

        $response = $this->post("/api/offers/$offer->id/apply");
        $response->assertStatus(201);
        $response->assertJson(["message" => "Application created successfully."]);
        $this->assertDatabaseHas("offer_users", ["user_id" => $user->id, "offer_id" => $offer->id]);
    }
    public function testCreateOfferUserUnathenticated()
    {
        $offer = factory(Offer::class)->create();

        $response = $this->withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->post("/api/offers/$offer->id/apply");

        $response->assertStatus(401);
        $response->assertJson(["message" => "Unauthenticated."]);
    }
    public function testCreateOfferUserOfferNotFound()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $offer = factory(Offer::class)->create();

        $response = $this->post("/api/offers/10000/apply");
        $response->assertStatus(404);
        $response->assertJson(["message" => "Resource not found."]);
    }
    public function testCreateOfferUserOfferApproved()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $status = factory(Status::class)->create(["code" => "approved"]);
        $offer = factory(Offer::class)->create(["status_id" => $status->id]);

        $response = $this->post("/api/offers/$offer->id/apply");
        $response->assertStatus(422);
        $response->assertJson(["data" => ["message" => "This offer has already been approved."]]);
    }
}
