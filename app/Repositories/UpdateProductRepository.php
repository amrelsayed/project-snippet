<?php

namespace App\Repositories;

use App\Product;
use App\ProductImage;

class UpdateProductRepository
{
	protected $destination;
	protected $thumb_destination;

	public function __construct()
	{
		$this->destination = public_path('seller_assets/products');
		$this->thumb_destination = public_path('seller_assets/products/thumbs');
	}

	public function execute($product_id, $seller_id)
	{
        $data = request()->all();
        $data['lowest_price'] = request()->price * request()->lowest;

        $product = Product::where('seller_id', $seller_id)->find($product_id);

        if ($product) {
        	$product->update($data);
        	$this->updateFeaturedImage($product);
        	$this->updateImages($product->id);
        }
	}

	protected function updateFeaturedImage($product)
	{
		if (request()->hasFile('image')) {			
			$this->deleteOldImage($product->image);
            $this->addNewImage($product);
        }
	}

	protected function deleteOldImage($image)
	{
		if (isset($image) && file_exists($this->destination . '/' . $image)) {
            unlink($this->destination . '/' . $image);
        }

        if ($image && file_exists($this->thumb_destination . '/' . $image)) {
            unlink($this->thumb_destination . '/' . $image);   
        }
	}

	public function addNewImage($product)
	{
		$featured_image = request()->file('image');
        $name = time() . '_' . $featured_image->getClientOriginalName();
        $featured_image->move($this->destination, $name);

        $product->image = $name;
        $product->save();
	}

	protected function updateImages($product_id)
	{
		if (request()->hasFile('images')) {
            foreach (request()->file('images') as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $image->move($this->destination, $name);

                ProductImage::create([
                    'image' => $name,
                    'product_id' => $product_id
                ]);
            }
        }
	}

}