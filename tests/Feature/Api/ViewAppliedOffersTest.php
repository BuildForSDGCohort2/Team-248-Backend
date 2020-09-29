<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\OfferUser;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewAppliedOffersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    const PER_PAGE = 10;

    public function testViewAppliedOffersSuccess()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        factory(OfferUser::class, 10)->create(['user_id' => $user->id]);

        $user2 = factory(User::class)->create();
        factory(OfferUser::class, 10)->create(['user_id' => $user2->id]);

        $response = $this->post('/api/applied-offers');
        $response->assertStatus(200);
        $data = $response->decodeResponseJson()["data"];
        foreach ($data as $offer) {
            $this->assertEquals($offer['application_data']["user_id"], $user->id);
        }
    }

    public function testViewAppliedOfferUnauthenticated()
    {
        $user = factory(User::class)->create();
        factory(OfferUser::class, 10)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->post('/api/applied-offers');

        $response->assertStatus(401);
        $response->assertJson(["message" => "Unauthenticated."]);
    }

    public function testViewAppliedOffersPagination()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        factory(OfferUser::class, 20)->create(['user_id' => $user->id]);

        $response = $this->post('/api/applied-offers');
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['per_page' => self::PER_PAGE]]);
        $data = $response->decodeResponseJson()["data"];
        foreach ($data as $offer) {
            $this->assertEquals($offer['application_data']["user_id"], $user->id);
        }
    }

    public function testViewAppliedOffersByCategory()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $cat1 = factory(OfferCategory::class)->create();
        $cat2 = factory(OfferCategory::class)->create();
        $offer1 = factory(Offer::class)->create(["category_id" => $cat1->id]);
        factory(Offer::class)->create(["category_id" => $cat2->id]);

        factory(OfferUser::class)->create(['user_id' => $user->id, 'offer_id' => $offer1->id]);


        $response = $this->post('/api/applied-offers?category_id=' . $cat1->id);
        $data = $response->decodeResponseJson()["data"];
        foreach ($data as $offer) {
            $this->assertEquals($offer["category"]["name"], $cat1->name);
        }
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['total' => 1]]);
    }
}
