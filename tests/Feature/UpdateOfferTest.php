<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateOfferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUpdateOfferSuccess()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);
        $data = [
            "category_id" => factory(OfferCategory::class)->create()->id,
            "start_at" => Carbon::now()->format('Y-m-d H:s:i'),
            "end_at" =>  Carbon::now()->addDay()->format('Y-m-d H:s:i'),
            "price_per_hour" => 90,
            "address" => "dummyaddress",
            "preferred_qualifications" => "dummyqualifications"
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->json('PUT', '/api/offers/' . $offer->id, $data);
        $response->assertStatus(200);
        $response->assertJson(["message" => "Offer updated successfully."]);
        $this->assertDatabaseHas("offers", $data);
    }

    public function testUpdateOfferValidationRequiredFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, []);
        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["category_id", "start_at", "end_at", "price_per_hour", "address"]);
    }

    public function testUpdateOfferValidationPriceTypeFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);
        $data = factory(Offer::class)->raw(["price_per_hour" => "dummy string"]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testUpdateOfferValidationPriceMinFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);
        $data = factory(Offer::class)->raw(["price_per_hour" => 0]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testUpdateOfferValidationPriceMaxFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);
        $data = factory(Offer::class)->raw(["price_per_hour" => 20000]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["price_per_hour"]);
    }

    public function testUpdateOfferValidationAddressMaxFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);
        $data = factory(Offer::class)->raw(["address" => $this->faker->text(1000)]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["address"]);
    }

    public function testUpdateOfferValidationPreferredQualificationsMaxFail()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);
        $data = factory(Offer::class)->raw(["preferred_qualifications" => $this->faker->text(1000)]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["preferred_qualifications"]);
    }

    public function testUpdateOfferNotFound()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->put('/api/offers/1000', []);
        $response->assertStatus(404);
        $response->assertJson(["message" => "Resource not found."]);
    }

    public function testUpdateOfferCategoryNotFound()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user->id]);
        $data = [
            "category_id" => 1000,
            "start_at" => Carbon::now()->format('Y-m-d H:s:i'),
            "end_at" =>  Carbon::now()->addDay()->format('Y-m-d H:s:i'),
            "price_per_hour" => 90,
            "address" => "dummyaddress",
            "preferred_qualifications" => "dummyqualifications"
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, $data);
        $response->assertStatus(422);
        $response->assertJson(["data" => ["message" => "The given data was invalid."]]);
    }

    public function testUpdateOfferUnauthenticated()
    {
        $offer = factory(Offer::class)->create();
        $data = [
            "category_id" => 1000,
            "start_at" => Carbon::now()->format('Y-m-d H:s:i'),
            "end_at" =>  Carbon::now()->addDay()->format('Y-m-d H:s:i'),
            "price_per_hour" => 90,
            "address" => "dummyaddress",
            "preferred_qualifications" => "dummyqualifications"
        ];
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, $data);
        $response->assertStatus(401);
        $response->assertJson(["data" => ["message" => "User Unauthenticated"]]);
    }

    public function testUpdateOfferUnauthorized()
    {
        $user = factory(User::class)->create(['password' => 'Test@123']);
        $user2 = factory(User::class)->create();
        $token = $this->userAuthToken($user);

        $offer = factory(Offer::class)->create(["user_id" => $user2->id]);
        $data = [
            "category_id" => factory(OfferCategory::class)->create()->id,
            "start_at" => Carbon::now()->format('Y-m-d H:s:i'),
            "end_at" =>  Carbon::now()->addDay()->format('Y-m-d H:s:i'),
            "price_per_hour" => 90,
            "address" => "dummyaddress",
            "preferred_qualifications" => "dummyqualifications"
        ];
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->json('PUT', '/api/offers/' . $offer->id, $data);

        $response->assertStatus(403);
        $response->assertJson(["message" => "This action is unauthorized."]);
    }
}
