<?php

namespace Tests\Feature;

use App\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOfferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateOfferSuccess()
    {
        $data = factory(Offer::class)->raw();
        unset($data["status_id"]);
        $response = $this->post('/api/offers', $data);
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
        $this->assertDatabaseHas("offers", $data);
    }

    public function testCreateOfferValidationRequiredFail()
    {
        $response = $this->post('/api/offers', []);

        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJsonValidationErrors(["user_id", "category_id", "start_at", "end_at", "price_per_hour", "address"]);
    }

    public function testCreateOfferValidationDateFail()
    {
        $data = factory(Offer::class)->raw(["start_at" => "dummy string", "end_at" => 123]);
        $response = $this->post('/api/offers', $data);

        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJsonValidationErrors(["start_at", "end_at"]);
    }

    public function testCreateOfferValidationEndAfterStartFail()
    {
        $data = factory(Offer::class)->raw(["start_at" => "2020-08-26 05:00:00", "end_at" => "2020-08-25 05:00:00"]);
        $response = $this->post('/api/offers', $data);

        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJsonValidationErrors(["end_at"]);
    }

    public function testCreateOfferValidationPriceTypeFail()
    {
        $data = factory(Offer::class)->raw(["price_per_hour" => "dummy string"]);
        $response = $this->post('/api/offers', $data);

        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testCreateOfferValidationPriceMinFail()
    {
        $data = factory(Offer::class)->raw(["price_per_hour" => 0]);
        $response = $this->post('/api/offers', $data);

        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testCreateOfferValidationPriceMaxFail()
    {
        $data = factory(Offer::class)->raw(["price_per_hour" => 20000]);
        $response = $this->post('/api/offers', $data);

        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testCreateOfferValidationAddressMaxFail()
    {
        $data = factory(Offer::class)->raw(["address" => $this->faker->text(1000)]);
        $response = $this->post('/api/offers', $data);

        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJsonValidationErrors(["address"]);
    }

    public function testCreateOfferValidationPreferredQualificationsMaxFail()
    {
        $data = factory(Offer::class)->raw(["preferred_qualifications" => $this->faker->text(1000)]);
        $response = $this->post('/api/offers', $data);

        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJsonValidationErrors(["preferred_qualifications"]);
    }
}
