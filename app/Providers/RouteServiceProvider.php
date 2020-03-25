<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapSellerRoutes();

        //
    }

    /**
     * Define the "seller" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapSellerRoutes()
    {
        Route::group([
            'middleware' => ['web'],
            'prefix' => 'seller',
            'as' => 'seller.',
            'namespace' => $this->namespace . '\Seller',
        ], function ($router) {
            require base_path('routes/seller.php');
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));

        Route::prefix('api/v1')
             ->middleware('api')
             ->namespace($this->namespace . '\Api\V1')
             ->group(base_path('routes/apiv1.php'));

        Route::prefix('api/v2')
             ->middleware('api')
             ->namespace($this->namespace . '\Api\V2')
             ->group(base_path('routes/apiv2.php'));
    }
}
