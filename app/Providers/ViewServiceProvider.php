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
         * Load the dashboard blade files for request creation.
         */
        $this->loadViewsFrom(resource_path('views/backend'), 'dashboard');

        /*
         * Load the websites blade files for request creation.
         */
        $this->loadViewsFrom(resource_path('views'), 'website');

        /*
         * Errors can be overwritten by the front end website, default to dashboard errors.
         */
        $this->loadViewsFrom([resource_path('views/errors'), resource_path('views/backend/errors')], 'errors');
    }
}
