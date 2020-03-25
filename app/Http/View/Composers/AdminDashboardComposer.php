<?php

namespace App\Http\View\Composers;

use App\Complaint;
use App\Product;
use App\Wrong;
use Illuminate\View\View;

class AdminDashboardComposer
{
	/**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $pending_products_count = Product::where('status', 0)->count();
        $complaints_count = Complaint::count();
        $error_reporting_count = Wrong::count();

        $view->with('pending_products_count', $pending_products_count)
        	->with('complaints_count', $complaints_count)
        	->with('error_reporting_count', $error_reporting_count);
    }
}