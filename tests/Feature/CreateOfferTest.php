<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CreateOfferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateOfferSuccess()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $data = factory(Offer::class)->raw();
        unset($data["status_id"]);
        unset($data["user_id"]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', $data);
        $response->assertStatus(201);
        $response->assertJson(["message" => "Offer created successfully."]);
        $this->assertDatabaseHas("offers", $data);
    }

    public function testCreateOfferValidationRequiredFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', []);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["category_id", "start_at", "end_at", "price_per_hour", "address"]);
    }

    public function testCreateOfferValidationDateFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $data = factory(Offer::class)->raw(["start_at" => "dummy string", "end_at" => 123]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["start_at", "end_at"]);
    }

    public function testCreateOfferValidationEndAfterStartFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $data = factory(Offer::class)->raw(["start_at" => "2020-08-26 05:00:00", "end_at" => "2020-08-25 05:00:00"]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["end_at"]);
    }

    public function testCreateOfferValidationPriceTypeFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $data = factory(Offer::class)->raw(["price_per_hour" => "dummy string"]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testCreateOfferValidationPriceMinFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $data = factory(Offer::class)->raw(["price_per_hour" => 0]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testCreateOfferValidationPriceMaxFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $data = factory(Offer::class)->raw(["price_per_hour" => 20000]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testCreateOfferValidationAddressMaxFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $data = factory(Offer::class)->raw(["address" => $this->faker->text(1000)]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["address"]);
    }

    public function testCreateOfferValidationPreferredQualificationsMaxFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $data = factory(Offer::class)->raw(["preferred_qualifications" => $this->faker->text(1000)]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('POST', '/api/offers', $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["preferred_qualifications"]);
    }

    public function testCreateOfferUnauthenticated()
    {
        $data = factory(Offer::class)->raw();
        unset($data["status_id"]);
        unset($data["user_id"]);
        $response = $this->withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->json('POST', '/api/offers', $data);
        $response->assertStatus(401);
        $response->assertJson(["data" => ["message" => "User Unauthenticated"]]);
    }
}
