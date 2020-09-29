<?php

namespace App\Repositories;

use App\Models\OfferCategory;

class OfferCategoryRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new OfferCategory();
    }
}
