<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id', 'category_id', 'start_at',
        'end_at', 'price_per_hour',
        'address', 'preferred_qualifications', 'status_id',
        'title', 'description', 'exp_from', 'exp_to'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(OfferCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function applicants(){
        return $this->hasManyThrough(User::class,
            OfferUser::class,
            'offer_users.offer_id',
            'users.id',
            'id',
            'offer_users.user_id');
    }

    public function offerUsers(){
        return $this->hasMany(\App\Models\OfferUser::class, 'offer_id');
    }

}
