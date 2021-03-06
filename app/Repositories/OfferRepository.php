<?php

namespace App\Repositories;

use App\Models\Offer;

class OfferRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Offer();
    }

    public function getNewOffers($userId, $categoryId = null)
    {
        $conditions = [
            ["user_id", "!=", $userId],
        ];
        if ($categoryId) {
            $conditions[] = ["category_id", "=", $categoryId];
        }
        $this->findWhere($conditions)->with(['category', 'status']);
        return $this->model->whereHas('status', function ($q) {
            $q->where('status.code', "new");
        });
    }

    public function getAppliedOffers($user_id, $status_id){
        $this->model = $this->model->whereHas('offerUsers', function ($query) use($user_id, $status_id){
            $query->where('user_id', $user_id);
            if($status_id) {
                $query->where('status_id', $status_id);
            }
        });
        return $this;
    }
}
