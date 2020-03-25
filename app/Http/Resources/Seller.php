<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Seller extends JsonResource
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
            'personal' => [
                'id' => $this->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'image' => asset('seller_assets/users/'.$this->image),
            ],
            'company' => [
                'about' => $this->about,
                'address' => $this->address,
                'shipping' => $this->shipping,
                'city_id' => $this->city_id
            ]
        ];
    }
}
