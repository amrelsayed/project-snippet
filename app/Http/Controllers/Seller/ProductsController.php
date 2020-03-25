<?php

namespace App\Http\Controllers\Seller;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Origin;
use App\Product;
use App\ProductImage;
use App\Repositories\DeleteProductRepository;
use App\Repositories\FeaturedProductRepository;
use App\Repositories\SellerProductsRepository;
use App\Repositories\StoreProductRepository;
use App\Repositories\UpdateProductRepository;
use App\Services\SellerService;
use App\SubCategory;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    private $listSellerProductsRepository;
    private $featuredProductRepository;
    private $deleteProductRepository;
    private $storeProductRepository;
    private $updateProductRepository;
    private $sellerService;

    public function __construct(
        SellerProductsRepository $sellerProductsRepository,
        FeaturedProductRepository $featuredProductRepository,
        DeleteProductRepository $deleteProductRepository,
        StoreProductRepository $storeProductRepository,
        UpdateProductRepository $updateProductRepository,
        SellerService $sellerService
    ) {
        $this->sellerProductsRepository = $sellerProductsRepository;
        $this->featuredProductRepository = $featuredProductRepository;
        $this->deleteProductRepository = $deleteProductRepository;
        $this->storeProductRepository = $storeProductRepository;
        $this->updateProductRepository = $updateProductRepository;
        $this->sellerService = $sellerService;
    }
    
    public function index(Request $request)
    {
        $products = $this->sellerProductsRepository->listWithFilters($request, Auth::guard('seller')->user()->id);

    	return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        extract($this->productLoadedData());

        return view('seller.products.create', compact('categories', 'subcategories', 'origins', 'units'));
    }

    public function store(StoreProduct $request)
    {
        if ($this->sellerService->isExceededProductsLimit(Auth::guard('seller')->user()->id)) {
            return redirect()->back()->with('error', trans('seller.subscribe_msg'));
        }

        $this->storeProductRepository->execute(Auth::guard('seller')->user()->id);

        return redirect('seller/products?filter=pending')->with('success', trans('product.added_success'));
    }

    public function edit($product_id)
    {
        extract($this->productLoadedData());
        
        $product = Product::where('seller_id', Auth::guard('seller')->user()->id)
            ->with('images')
            ->findOrFail($product_id);

        return view('seller.products.edit', compact('categories', 'origins', 'units', 'subcategories', 'product'));
    }

    public function update(UpdateProduct $request, $id)
    {
        if ($this->sellerService->isFreeSubscribtion(Auth::guard('seller')->user()->id)) {
            return redirect()->back()->with('error', trans('seller.subscribe_msg'));
        }

        $this->updateProductRepository->execute($id, Auth::guard('seller')->user()->id);

        return redirect('seller/products?filter=pending')->with('success', trans('product.added_success'));
    }

    public function destroy($id)
    {
        $this->deleteProductRepository->execute($id, 'Seller', Auth::guard('seller')->user()->id);

        return redirect()->back()->with('success', trans('general.deleted'));
    }

    /**
    * FrontEnd have to send featured param in the request with 1 || 0 to set or unset
    */
    public function setUnsetFeatured(Request $request, $id)
    {
    	$response = $this->featuredProductRepository->setUnset($request, $id, Auth::guard('seller')->user()->id);

        if ($response['success'])
            return redirect()->back()->with('success', $response['msg']);

        return redirect()->back()->with('error', $response['msg']);
    }

    public function deleteImage()
    {
        $this->deleteProductRepository->deleteImage(request()->get('image_id'));

        return ProductImage::where('product_id', request()->get('product_id'))->get();
    }

    protected function productLoadedData()
    {
        return array(
            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
            'origins' => Origin::all(),
            'units' => Unit::all()
        );
    }
}
