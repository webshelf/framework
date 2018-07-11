<?php

namespace App\Providers;

use App\Model\Article;
use App\Model\Categories;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 01/02/2017
 * Time: 10:05.
 */
class InstanceServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * Bootstrap application.
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('articles', function () {
            return Article::where('status', true)->with('category')->get();
        });

        $this->app->singleton('article.categories', function () {
            return Categories::where('status', true)->get();
        });

        $this->app->singleton('article.creators', function () {
            return Article::where('status', true)->with('creator')->get();
        });
    }
}
