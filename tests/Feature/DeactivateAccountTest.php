<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeactivateAccountTest extends TestCase
{
    use RefreshDatabase;
    
    public function testDeactivateAccountSuccess()
    {
        $user = factory(User::class)->create(["is_active"=>1]);
        Sanctum::actingAs($user);

        $response = $this->patch("/api/users/deactivate");

        $response->assertStatus(200);
        $response->assertJson(["message" => "Account deactivated successfully."]);
        $this->assertDatabaseHas("users", ["id"=>$user->id,"is_active"=>0]);
    }

    public function testDeactivateAccountUnauthenticated()
    {
        $response = $this->withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->patch("/api/users/deactivate");
        $response->assertStatus(401);
        $response->assertJson(["message" => "Unauthenticated."]);
    }
}
