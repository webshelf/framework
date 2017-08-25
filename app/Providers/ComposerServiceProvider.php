<?php
/**
 * Created by PhpStorm.
 * User: Jessica
 * Date: 29/04/2017
 * Time: 22:55.
 */

namespace App\Providers;

use App\Composer\BreadcrumbComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'dashboard::frame', BreadcrumbComposer::class
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
