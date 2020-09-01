<?php

namespace App\Repositories;

use App\Models\Status;

class StatusRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Status();
    }
}
