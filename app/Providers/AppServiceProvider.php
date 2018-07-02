<?php

namespace App\Providers;

use App\Model\Article;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootBladeDirectives();

        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot blade directives.
     *
     * @return void
     */
    private function bootBladeDirectives()
    {
        Blade::if('role', function ($role) {
            return account()->hasRole($role);
        });
    }
}
