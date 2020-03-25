<?php

namespace App\Repositories;

use App\Product;
use App\ProductImage;

class StoreProductRepository
{
	public function execute($seller_id)
	{
        $data = request()->all();
        $data['seller_id'] = $seller_id;
        $data['featured'] = 1;
        $data['lowest_price'] = request()->price * request()->lowest;

        $product = Product::create($data);

        $this->addFeaturedImage($product);

        $this->addImages($product->id);
	}

	protected function addFeaturedImage($product)
	{
		$destination = public_path('seller_assets/products');

		if (request()->hasFile('image')) {
            $featured_image = request()->file('image');
            $name = time() . '_' . $featured_image->getClientOriginalName();
            $featured_image->move($destination, $name);

            $product->image = $name;
            $product->save();
        }
	}

	protected function addImages($product_id)
	{
		$destination = public_path('seller_assets/products');

		if (request()->hasFile('images')) {
            foreach (request()->file('images') as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $image->move($destination, $name);

                ProductImage::create([
                    'image' => $name,
                    'product_id' => $product_id
                ]);
            }
        }
	}
}