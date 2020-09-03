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
        $data = [
            "user_id" => $offer->id,
            "category_id" => factory(OfferCategory::class)->create()->id,
            "start_at" => $this->faker->dateTimeInInterval("+2 days", "+4 days"),
            "end_at" => $this->faker->dateTimeInInterval("+5 days", "+7 days"),
            "price_per_hour" => 90,
            "address" => "dummyaddress",
            "preferred_qualifications" => "dummyqualifications"
        ];
        $response = $this->put('/api/offers/' . $offer->id, $data);
        $response->assertStatus(200);
        $response->assertJson(["message" => "Offer updated successfully."]);
        $this->assertDatabaseHas("offers", $data);
    }

    public function testUpdateOfferValidationRequiredFail()
    {
        $offer = factory(Offer::class)->create();
        $response = $this->put('/api/offers/' . $offer->id, []);
        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["user_id", "category_id", "start_at", "end_at", "price_per_hour", "address"]);
    }

    public function testUpdateOfferValidationPriceTypeFail()
    {
        $offer = factory(Offer::class)->create();
        $data = factory(Offer::class)->raw(["price_per_hour" => "dummy string"]);
        $response = $this->put('/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testUpdateOfferValidationPriceMinFail()
    {
        $offer = factory(Offer::class)->create();
        $data = factory(Offer::class)->raw(["price_per_hour" => 0]);
        $response = $this->put('/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testUpdateOfferValidationPriceMaxFail()
    {
        $offer = factory(Offer::class)->create();
        $data = factory(Offer::class)->raw(["price_per_hour" => 20000]);
        $response = $this->put('/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testUpdateOfferValidationAddressMaxFail()
    {
        $offer = factory(Offer::class)->create();
        $data = factory(Offer::class)->raw(["address" => $this->faker->text(1000)]);
        $response = $this->put('/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["address"]);
    }

    public function testUpdateOfferValidationPreferredQualificationsMaxFail()
    {
        $offer = factory(Offer::class)->create();
        $data = factory(Offer::class)->raw(["preferred_qualifications" => $this->faker->text(1000)]);
        $response = $this->put('/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["preferred_qualifications"]);
    }

    public function testUpdateOfferNotFound()
    {
        $response = $this->put('/api/offers/1000', []);
        $response->assertStatus(404);
        $response->assertJson(["message" => "Resource not found."]);
    }

    public function testUpdateOfferCategoryNotFound()
    {
        $offer = factory(Offer::class)->create();
        $data = [
            "user_id" => $offer->id,
            "category_id" => 1000,
            "start_at" => $this->faker->dateTimeInInterval("+2 days", "+4 days"),
            "end_at" => $this->faker->dateTimeInInterval("+5 days", "+7 days"),
            "price_per_hour" => 90,
            "address" => "dummyaddress",
            "preferred_qualifications" => "dummyqualifications"
        ];
        $response = $this->put('/api/offers/' . $offer->id, $data);
        $response->assertStatus(422);
        $response->assertJson(["data"=>["message" => "The given data was invalid."]]);
    }
}
