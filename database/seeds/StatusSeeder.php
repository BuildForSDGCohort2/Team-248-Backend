<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Status::class)->create(["name" => "New", "description" => "A new offer was created", "code" => "new"]);
        factory(Status::class)->create(["name" => "Accepted", "description" => "User accept the application", "code" => "accepted"]);
        factory(Status::class)->create(["name" => "Denied", "description" => "User deny the application", "code" => "denied"]);
        factory(Status::class)->create(["name" => "Completed", "description" => "The offer completed", "code" => "completed"]);
        factory(Status::class)->create(["name" => "In-progress", "description" => "The offer's application is in progress", "code" => "inprogress"]);
    }
}
