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

class ViewOffersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    const PER_PAGE = 10;

    public function testViewUserOffersSuccess()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        factory(Offer::class, 10)->create(['user_id' => $user->id]);
        $response = $this->post('/api/user-offers');
        $response->assertStatus(200);
        $data = $response->decodeResponseJson()["data"];
        foreach ($data as $offer) {
            $this->assertEquals($offer["user_id"], $user->id);
        }
    }

    public function testViewUserOffersPagination()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        factory(Offer::class, 30)->create(['user_id' => $user->id]);
        $response = $this->post('/api/user-offers');
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['per_page' => self::PER_PAGE]]);
        $data = $response->decodeResponseJson()["data"];
        foreach ($data as $offer) {
            $this->assertEquals($offer["user_id"], $user->id);
        }
    }

    public function testViewUserOffersByCategory()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $cat1 = factory(OfferCategory::class)->create();
        $cat2 = factory(OfferCategory::class)->create();
        factory(Offer::class, 10)->create(["category_id" => $cat1->id, 'user_id' => $user->id]);
        factory(Offer::class, 20)->create(["category_id" => $cat2->id, 'user_id' => $user->id]);
        $response = $this->post('/api/user-offers?category_id=' . $cat1->id);
        $data = $response->decodeResponseJson()["data"];
        foreach ($data as $offer) {
            $this->assertEquals($offer["category"]["name"], $cat1->name);
        }
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['total' => 10]]);
    }
}
