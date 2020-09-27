<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\OfferUser;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ShowOfferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function user_not_auth_can_read_offer()
    {
        $offer = factory(Offer::class)->create();
        $response = $this->get('/api/offers/'.$offer->id);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $offer->id
        ]);
        // not auth user cant see:
        // - The application details if he applied on the offer before.
        // - The applicants details or status if he is the owner of the offer.
        $response->assertJsonMissing([
            'application_data',
            'applicants',
            'status'
        ]);
    }

    /** @test */
    public function user_auth_can_read_his_offer_and_applicants()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $offer = factory(Offer::class)->create();
        $offer->user_id = $user->id;
        $offer->save();
        $response = $this->get('/api/offers/'.$offer->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            'id',
            'applicants',
            'status'
        ]]);

        $response->assertJsonMissing([
            'application_data',
        ]);
    }

    /** @test */
    public function user_auth_can_read_his_applied_offer_and_details()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $offer = factory(Offer::class)->create();
        OfferUser::create([
            'offer_id' => $offer->id,
            'user_id' => $user->id,
            'status_id' => (factory(Status::class)->create())->id]);

        $response = $this->get('/api/offers/'.$offer->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            'id',
            'application_data',
        ]]);

        $response->assertJsonMissing([
            'applicants',
            'status',
        ]);
    }

    public function user_cant_see_not_exist_offer()
    {
        $response = $this->get('/api/offers/1000000');
        $response->assertStatus(404);
        $response->assertJson(["message" => "Resource not found."]);
    }
}
