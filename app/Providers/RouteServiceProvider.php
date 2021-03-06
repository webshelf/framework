<?php

namespace App\Providers;

use PDOException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Modules\ModuleServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider.
 */
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
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        try {
            ModuleServiceProvider::map();

            Route::middleware('web')->group(base_path('routes/web.php'));

            Route::middleware('web')->group(base_path('routes/vendor.php'));
        } catch (PDOException $e) {
            Log::warning('Unable to process routes: '.$e->getMessage().', '.$e->getFile());
        }
    }
}
