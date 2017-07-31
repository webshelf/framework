<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 01/02/2017
 * Time: 18:51.
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        /*
         * Load the dashboard/admin blade files for views creation.
         */
        $this->loadViewsFrom(resource_path('admin/views'), 'dashboard');

        /*
         * Load the websites frontend blade files for views creation.
         */
        $this->loadViewsFrom(resource_path('views'), 'website');

        /*
         * Errors can be overwritten by the front end website, default to dashboard errors.
         */
        $this->loadViewsFrom([resource_path('views/errors'), resource_path('admin/views/errors')], 'errors');
    }
}
