<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
           'id' => $this->id,
           'name' => $this->name,
           'image' => asset('admin_assets/image/subCategory/' . $this->image),
           'icon' => asset('admin_assets/image/subCategory/' . $this->icon)
        ];
    }
}
