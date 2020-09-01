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
        factory(OfferCategory::class, 4)->create();
    }
}
