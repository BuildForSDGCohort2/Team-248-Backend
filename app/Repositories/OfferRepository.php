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
            ["status.code", "=", "new"]
        ];
        if ($categoryId) {
            $conditions[] = ["category_id", "=", $categoryId];
        }
        return $this->model->select("start_at", "end_at", "address", "price_per_hour",
            "offer_categories.name as category_name", "title", "description", "exp_from", "exp_to")
            ->where($conditions)
            ->join('status', 'offers.status_id', '=', 'status.id')
            ->join('offer_categories', 'offers.category_id', '=', 'offer_categories.id');
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
