<?php

namespace App\Http\Resources\Api\V1\Customer;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FaqsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($item){
                return [
                    'slug' => $item->slug,
                    'question' => $item->question,
                    'answer' => $item->answer,
                ];
            })
        ];
    }
}
