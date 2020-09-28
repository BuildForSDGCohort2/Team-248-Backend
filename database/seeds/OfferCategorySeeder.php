<?php

use App\Models\OfferCategory;
use Illuminate\Database\Seeder;

class OfferCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OfferCategory::class)->create(["name" => "Babysitting", "description" => "Request for a babysitter"]);
        factory(OfferCategory::class)->create(["name" => "Elderly Care", "description" => "Request for a sitter to keep the elderly company"]);
    }
}
