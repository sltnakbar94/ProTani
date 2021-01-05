<?php

namespace App\Http\Resources\Api\V1\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->user->name,
            'code' => $this->user->code,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
        ];
    }
}
