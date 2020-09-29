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

    public function testViewOffersSuccess()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $status = factory(Status::class)->create(["code" => "new"]);
        factory(Offer::class, 10)->create(["status_id" => $status->id]);
        $response = $this->get('/api/offers');
        $response->assertStatus(200);
        $response->assertJson(["message" => "Offers fetched successfully."]);
    }

    public function testViewOffersPagination()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        factory(Offer::class, 30)->create();
        $paginate = 20;
        $response = $this->get('/api/offers?paginate=' . $paginate);
        $response->assertStatus(200);
        $response->assertJson(["message" => "Offers fetched successfully."]);
        $response->assertJson(["data" => ["per_page" => $paginate]]);
    }

    public function testViewOffersByCategory()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $status = factory(Status::class)->create(["code" => "new"]);
        $cat1 = factory(OfferCategory::class)->create();
        $cat2 = factory(OfferCategory::class)->create();
        factory(Offer::class, 10)->create(["category_id" => $cat1->id, "status_id" => $status->id]);
        factory(Offer::class, 20)->create(["category_id" => $cat2->id, "status_id" => $status->id]);
        $response = $this->get('/api/offers?category_id=' . $cat1->id);
        $data = $response->decodeResponseJson()["data"]["data"];
        foreach ($data as $offer) {
            $this->assertEquals($offer["category_name"], $cat1->name);
        }
        $response->assertStatus(200);
        $response->assertJson(["message" => "Offers fetched successfully."]);
        $response->assertJson(["data" => ["total" => 10]]);
    }
}
