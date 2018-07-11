<?php

namespace App\Providers;

use Exception;
use App\Model\Article;
use App\Model\Categories;
use App\Classes\PluginManager;
use Illuminate\Foundation\Application;
use App\Exceptions\EngineBootException;
use Illuminate\Support\ServiceProvider;
use App\Classes\Repositories\PluginRepository;

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
        $this->makePluginInstance();

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

    private function makePluginInstance()
    {
       throw new \Exception("Depreciated, Use Modules instead.");
    }
}
