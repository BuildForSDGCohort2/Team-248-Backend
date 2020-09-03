<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateOfferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUpdateOfferSuccess()
    {
        $offer = factory(Offer::class)->create();
        $update = [
            "user_id" => $offer->id,
            "category_id" => factory(OfferCategory::class)->create()->id,
            "start_at" => $this->faker->dateTimeInInterval("+2 days", "+4 days"),
            "end_at" => $this->faker->dateTimeInInterval("+5 days", "+7 days"),
            "price_per_hour" => 90,
            "address" => "dummyaddress",
            "preferred_qualifications" => "dummyqualifications"
        ];
        $response = $this->put('/api/offers/' . $offer->id, $update);
        $response->assertStatus(200);
        $response->assertJson(["message" => "Offer updated successfully."]);
        $this->assertDatabaseHas("offers", $update);
    }
}
