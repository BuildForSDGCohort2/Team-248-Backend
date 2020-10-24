<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteOfferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testDeleteOfferSuccess()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->delete('/api/offers/' . $offer->id);
        $offer->refresh();
        $response->assertStatus(200);
        $response->assertJson(["message" => "Offer deleted successfully."]);
        $this->assertNotNull($offer->deleted_at);
    }

    public function testDeleteOfferUnauthenticated()
    {

        $offer = factory(Offer::class)->create();

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->delete('/api/offers/' . $offer->id);

        $response->assertStatus(401);
        $response->assertJson(["data" => ["message" => "User Unauthenticated"]]);
    }

    public function testDeleteOfferUnauthorized()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $user2 = factory(User::class)->create();
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user2->id]);

        $response =  $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $token,
        ])->delete('/api/offers/' . $offer->id);
        $offer->refresh();
        $response->assertStatus(403);
        $response->assertJson(["data"=>["message" => "This action is unauthorized."]]);
    }
}
