<?php namespace App\Repositories;

use App\Models\PasswordReset;

class PasswordResetRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new PasswordReset();
    }
}
