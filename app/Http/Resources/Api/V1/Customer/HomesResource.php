<?php

namespace App\Http\Resources\Api\V1\Customer;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Traits\DelitrackTrait;
use Storage;

class HomesResource extends ResourceCollection
{
    use DelitrackTrait;

    public function __construct($collection, $banner)
    {
        $this->collection = $collection;
        $this->banner = $banner;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'banner' => $this->banner,
                'nearby' => $this->collection->map(function($item){
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'image' => [
                            'small' => $this->getResponsiveImage('small', Storage::disk('merchant')->url($item->image)),
                            'medium' => $this->getResponsiveImage('medium', Storage::disk('merchant')->url($item->image)),
                            'large' => $this->getResponsiveImage('large', Storage::disk('merchant')->url($item->image)),
                            'original' => $this->getResponsiveImage('original', Storage::disk('merchant')->url($item->image)),
                        ],
                        'rate' => $item->getRating(),
                        'restaurant_types' => $item->getRestaurantTypes(),
                        'cuisines' => $item->getCuisines(),
                        'distance' => number_format(($item->distance * 0.621), 1, ',', '.') . ' km',
                        'address' => $item->getAddress(),
                        'lat' => $item->lat,
                        'lng' => $item->lng,
                    ];
                })
            ]
        ];
    }
}
