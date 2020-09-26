<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ApplicantCollection extends ResourceCollection
{

    protected $offer_id;

    public function setOfferId($offer_id){
        $this->offer_id = $offer_id;
        return $this;
    }

    public function toArray($request){
        return $this->collection->map(function(ApplicantResource $resource) use($request){
            return $resource->setOfferId($this->offer_id)->toArray($request);
        })->all();
    }

}
