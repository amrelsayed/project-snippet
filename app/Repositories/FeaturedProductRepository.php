<?php

namespace App\Repositories;

use App\Product;
use App\ProductImage;
use App\Seller;
use Intervention\Image\Facades\Image;

class FeaturedProductRepository
{
	public function setUnset($request, $product_id, $seller_id)
    {
        $seller = Seller::where('id', $seller_id)
            ->with('subscribtion')
            ->withCount('featuredProducts')
            ->first();

        $product = Product::where('id', $product_id)
            ->where('seller_id', $seller_id)
            ->first();

        if (! $product || ! $seller) {
            return array('success' => false, 'msg' => trans('general.notfound'));
        }

        if ($seller->subscribtion_id == Seller::SUBSCRIBTIONS_ENUM['FREE']) {
            return array('success' => false, 'msg' => trans('seller.you_have_free_subscribtion'));
        }

        if ($request->featured == 1 || $request->featured == 'true') {
            if ($seller->featured_products_count >= $seller->subscribtion['featured_products']) {
                return array('success' => false, 'msg' => trans('seller.reached_featured_products_quota'));
            }

            $this->featureProduct($product);
        } elseif ($request->featured == 0 || $request->featured == 'false') {
            $this->unFeatureProduct($product);
        }

        return array('success' => true, 'msg' => trans('general.success_msg'));
    }

    protected function featureProduct($product)
    {
        $product->featured = 10;
        $product->save();

        $this->createFeaturedProductImagesThumbs($product->id);
    }
    
    protected function unFeatureProduct($product)
    {
        $product->featured = Seller::SUBSCRIBTIONS_ENUM['FREE'];
        $product->save();

        $this->removeFeaturedProductImagesThumbs($product->id);
    }

    protected function createFeaturedProductImagesThumbs($product_id)
    {
        $dest = public_path('seller_assets/products/thumbs/');
        $image_path = public_path('seller_assets/products/');

        $images = ProductImage::where('product_id', $product_id)->get();

        if (isset($images) && count($images) > 0) {
            foreach($images as $image) {
                if (file_exists($image_path . $image->image)) {
                    Image::make($image_path . $image->image)->resize(215, 400, function($constraint) {
                        $constraint->aspectRatio();
                    })->save($dest . $image->image);
                }
            }
        }
    }

    protected function removeFeaturedProductImagesThumbs($product_id)
    {
        $dest = public_path('seller_assets/products/thumbs/');
        
        $images = ProductImage::where('product_id', $product_id)->get();

        if (isset($images) && count($images) > 0) {
            foreach($images as $image) {
                if (file_exists($dest . $image->image)) {
                    unlink($dest . '/' . $image->image); 
                }
            }
        } 
    }
}