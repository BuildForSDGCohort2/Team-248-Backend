<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteOfferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testDeleteOfferSuccess()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);

        $response = $this->delete('/api/offers/' . $offer->id);
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
        $response->assertJson(["message" => "Unauthenticated."]);
    }

    public function testDeleteOfferUnauthorized()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        Sanctum::actingAs($user);

        $offer = factory(Offer::class)->create(["user_id" => $user2->id]);

        $response =  $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->delete('/api/offers/' . $offer->id);
        $offer->refresh();
        $response->assertStatus(403);
        $response->assertJson(["data"=>["message" => "This action is unauthorized."]]);
    }
}
