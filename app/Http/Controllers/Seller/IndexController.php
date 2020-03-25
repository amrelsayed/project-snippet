<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
    	$stats = Product::selectRaw('
    		count(*) as products_count,
    		sum(views) as products_views,
    		sum(clicks) as products_clicks,
            sum(favourite) as products_favourites
    		')
    	->groupBy('seller_id')
    	->where('seller_id', Auth::guard('seller')->user()->id)
    	->first();
        
    	return view('seller.index', compact('stats'));
    }
}
