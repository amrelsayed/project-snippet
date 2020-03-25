<?php

namespace App\Repositories;

use App\Product;
use App\ProductImage;

class DeleteProductRepository
{
	public function execute($product_id, $user_type = null, $user_id = null)
    {       
        $query = Product::where('id', $product_id);

        if ($user_type == 'Seller')
            $query->where('seller_id', $user_id);
        
        $product = $query->first();
        
        if (! $product) {
            return false;
        }

        $product->delete();
        $product->deleted_by_id = $user_id;
        $product->deleted_by_type = $user_type;
        $product->save();
    }

    public function deleteImage($image_id)
    {
        $image = ProductImage::find(request()->get('image_id'));

        $destination = public_path('seller_assets/products');

        if (file_exists($destination . '/' . $image->image)) {
            unlink($destination . '/' . $image->image);
        }

        $image->delete();
    }
}