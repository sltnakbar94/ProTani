<?php

namespace App\Http\Resources\Api\V1\Merchant;

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
            'id' => $this->user->id,
            'name' => $this->user->name,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'address' => $this->user->address,
            'province' => $this->getProvince(),
            'regency' => $this->getRegency(),
            'district' => $this->getDistrict(),
            'postal_code' => $this->user->postal_code,
            'role' => $this->getRole(),
            'merchant' => $this->getMerchant(),
            'outlet' => $this->getOutlet(),
            'active' => $this->user->active,
        ];
    }

    private function getProvince()
    {
        if($this->user->province)
            return [
                'id' => $this->user->province->id,
                'name' => $this->user->province->name
            ];
    }

    private function getRegency()
    {
        if($this->user->regency)
            return [
                'id' => $this->user->regency->id,
                'name' => $this->user->regency->name
            ];
    }

    private function getDistrict()
    {
        if($this->user->district)
            return [
                'id' => $this->user->district->id,
                'name' => $this->user->regency->name
            ];
    }

    private function getRole()
    {
        $role = $this->user->roles->first();
            return [
                'id' => $role->id,
                'name' => $role->name,
            ];
    }

    public function getMerchant()
    {
        if($this->user->merchant)
            return [
                'id' => $this->user->merchant->id,
                'name' => $this->user->merchant->name,
            ];
    }

    public function getOutlet()
    {
        return $this->user->outlets->transform(function($outlet){
            return [
                'id' => $outlet->id,
                'name' => $outlet->name
            ];
        });
    }
}
