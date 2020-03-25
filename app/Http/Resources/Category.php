<?php

namespace App\Http\Resources;

use App\Http\Resources\SubCategory as SubCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
           'image' => asset('admin_assets/image/category/' . $this->image),
           'icon' => asset('admin_assets/image/category/' . $this->icon),
           'sub_categories' => SubCategoryResource::collection($this->whenLoaded('subCategories'))
        ];
    }
}
