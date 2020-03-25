<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductImage as ProductImageResource;
use App\Http\Resources\Seller as SellerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'price' => $this->price,
            'unit_id' => $this->unit_id, 
            'lowest' => $this->lowest, 
            'origin' => $this->origin, 
            'category_id' => $this->category_id, 
            'sub_id' => $this->sub_id, 
            'product_description' => $this->product_description, 
            'views' => $this->views, 
            'seller_id' => $this->seller_id, 
            'image' => asset('seller_assets/products/'.$this->image),
            'seller' => new SellerResource($this->whenLoaded('seller')),
            'images' => ProductImageResource::collection($this->whenLoaded('images'))
        ];
    }
}
