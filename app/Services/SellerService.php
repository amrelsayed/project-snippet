<?php

namespace App\Services;

use App\Seller;


class SellerService
{
	
	public function isExceededProductsLimit($seller_id)
	{
        $seller = Seller::where('id', $seller_id)
            ->withCount('products', 'deletedProducts')
            ->with('subscribtion')
            ->first();

        return $this->exceededLimit($seller) ? true : false;
	}

    public function isFreeSubscribtion($seller_id)
    {
        $seller = Seller::find($seller_id);

        return $seller->subscribtion_id == Seller::SUBSCRIBTIONS_ENUM['FREE'];
    }

    public function cannotUpdateProfile($seller)
    {
        if ($seller->subscribtion_id == Seller::SUBSCRIBTIONS_ENUM['FREE'] || 
            $seller->subscribtion_id == Seller::SUBSCRIBTIONS_ENUM['PAYED_1']
        ) {
            return true;
        }

        return false;
    }

    protected function exceededLimit($seller)
    {
        return ($seller->products_count > $seller->subscribtion['live_products']) ||
               (
                    ($seller->products_count + $seller->deleted_products_coun) > $seller->subscribtion['all_products']
                );
    }
}