<?php

namespace App\Repositories;

use App\Models\OfferUser;

class OfferUserRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new OfferUser();
    }
}
