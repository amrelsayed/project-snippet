<?php

namespace App\Http\Controllers\Seller;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSeller;
use App\Repositories\UpdateSellerRepository;
use App\Seller;
use App\Services\SellerService;
use App\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $sellerService;
    private $updateSellerRepository;

    public function __construct(
    	SellerService $sellerService, 
    	UpdateSellerRepository $updateSellerRepository
    ) {
    	$this->sellerService = $sellerService;
    	$this->updateSellerRepository = $updateSellerRepository;
    }

    public function index()
    {
    	$seller = Seller::find(Auth::guard('seller')->user()->id);
    	$cities = City::all();
    	$shippings = Shipping::all();

    	return view('seller.account.index', compact('seller', 'cities', 'shippings'));
    }

    public function update(UpdateSeller $request, $id)
    {
    	$seller = Seller::find($id);

    	if ($this->sellerService->cannotUpdateProfile($seller)) {
    		return redirect()->back()->with('error', trans('seller.subscribe_msg'));
    	}

    	$this->updateSellerRepository->execute($seller);
    	return redirect()->back()->with('success', trans('seller.edit_request_sent'));
    }
}
