<?php

namespace App\Repositories;

use App\Product;
use App\Services\ProductService;

class SellerProductsRepository
{
	public function listWithFilters($request, $seller_id)
    {
        $productService = new ProductService;

        $query = Product::selectRaw('id, name, product_description, unit_id, price, lowest, status, image, views, clicks, refuse_msg, featured, (clicks / (views + 1)) as interaction, favourite as favourites_num')
            ->where('seller_id', $seller_id);

        if (! empty($request->filter)) {
            $this->filter($query, $request);   
        }
        
        if (! empty($request->sort)) {
            $this->sort($query, $request);
        } else {
            $query->orderBy('featured', 'DESC')
            ->orderBy('id', 'DESC');           
        }

        return $productService->formatResponseList(
            $query->paginate(20)->appends([
                'filter' => $request->filter,
                'sort' => $request->sort
            ]), false
        );
    }

    protected function filter($query, $request)
    {
        switch ($request->filter) {
            case 'pending':
                $query->where('status', Product::STATUS_ENUM['PENDING']);
                break;
            
            case 'active':
                $query->where('status', Product::STATUS_ENUM['ACTIVE']);
                break;

            case 'refused':
                $query->where('status', Product::STATUS_ENUM['REFUSED']);
                break;

            case 'featured':
                $query->where('featured', 10);
                break;
        }
    }

    protected function sort($query, $request)
    {
        switch ($request->sort) {
            case 'newest':
                $query->orderBy('id', 'DESC');
                break;
            
            case 'oldest':
                $query->orderBy('id', 'ASC');
                break;

            case 'most_views':
                $query->orderBy('views', 'DESC');
                break;
            
            case 'least_views':
                $query->orderBy('views', 'ASC');
                break;

            case 'most_interaction':
                $query->orderBy('interaction', 'DESC');
                break;
            
            case 'least_interaction':
                $query->orderBy('interaction', 'ASC');
                break;
        }
    }
}