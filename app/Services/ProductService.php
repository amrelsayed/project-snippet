<?php

namespace App\Services;

use App\Models\User\SearchQuery;
use App\Product;
use App\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as RequestFacade;
use Intervention\Image\Facades\Image;
use GeoIp2\Database\Reader;

class ProductService
{
    public function formatResponseList($products, $with_dollar = true)
    {
        if ($with_dollar)
            $dollar_price = Settings::find(1)->dollar_price;

        foreach ($products as $product) {
            if (file_exists(public_path('seller_assets/products/thumbs/' . $product->image))) {
                $product->image = asset('seller_assets/products/thumbs/' . $product->image);    
            } else {
                $product->image = asset('seller_assets/products/' . $product->image);
            }
            
            if ($product->featured == 10) {
                $product->is_featured = true;
            } else {
                $product->is_featured = false;
            }

            if (isset($dollar_price))
                $product = $this->formatPrice($product, $dollar_price);
        }

        return $products;
    }

    public function formatPrice($product, $dollar_price = 17.30)
    {
        try {
            $reader = new Reader(public_path().'/website/geolite2_country.mmdb');
            
            $record = $reader->country(RequestFacade::ip());

            $country_code = $record->country->isoCode;

            if (! empty($country_code) &&
                $country_code != 'EG' && 
                RequestFacade::ip() != '127.0.0.1'
            ) {
                $product['currency'] = '$';
                $product['website_currency'] = 'دولار';
                $product['price'] = round($product['price'] / $dollar_price, 2);
            } else {
                $product['currency'] = $product['website_currency'] ='ج';
            }

            return $product;
        } catch (\Exception $e) {
            $product['currency'] = $product['website_currency'] ='ج';
            return $product;
        }
    }

    public function generateThumb($image)
	{
		$dest = public_path('seller_assets/products/thumbs/');
    	$image_path = public_path('seller_assets/products/');

		if (file_exists($image_path . $image)) {
            Image::make($image_path . $image)->resize(600, 800, function($constraint) {
                $constraint->aspectRatio();
            })
            ->save($dest . $image);
        }
	}

    public function handleSearchQuery($query, $request)
    {
        $query->selectRaw("match(name, product_description) against(? in boolean mode) as relevance", [$request->search])
            ->whereRaw("match(name, product_description) against(? in boolean mode)", [$request->search])
            ->orderByRaw('round(relevance/5) desc, featured desc, relevance desc');
        
        if (! $request->page || $request->page ==1) {
            $seach_query = new SearchQuery;
            $seach_query->input = $request->search;
            $seach_query->ip_address = RequestFacade::ip();
            $seach_query->save();
        }
    }

    public function increaseClicks($product_id)
    {
        $product = Product::find($product_id);

        if ($product) {
            if ($product->status == Product::STATUS_ENUM['ACTIVE']) {
                $product->increment('clicks');
                $product->save();

                return true;
            }
        }

        return false;
    }
}