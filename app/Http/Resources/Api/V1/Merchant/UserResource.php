<?php

namespace App\Http\Resources\Api\V1\Merchant;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->getRole(),
            'outlet' => $this->getOutlet(),
            'active' => $this->active
        ];
    }

    private function getRole()
    {
        $role = $this->roles->first();
            return [
                'id' => $role->id,
                'name' => $role->name,
            ];
    }

    public function getOutlet()
    {
        return $this->outlets->transform(function($outlet){
            return [
                'id' => $outlet->id,
                'name' => $outlet->name
            ];
        });
    }
}
