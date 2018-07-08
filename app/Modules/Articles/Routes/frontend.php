<?php

use App\Model\Page;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | Module Route Loading
    |--------------------------------------------------------------------------
    |
    | These are separated components in a form of modularity.
    | Upon production environments these will all be cached
    | allowing these to be loading one time per update.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | (Page Path = Articles Page '/articles')
    |--------------------------------------------------------------------------
    */
    Route::get(config('modules.articles.route'))->uses('FrontendController@allArticles')->name('articles.all');
    Route::get(config('modules.articles.route') .'/search')->uses('FrontendController@searchArticles')->name('search.articles');
    Route::get(config('modules.articles.route') .'/{category}')->uses('FrontendController@categoryArticles')->name('category.articles');
    Route::get(config('modules.articles.route') .'/creator/{account}')->uses('FrontendController@allCreatorsArticles')->name('creator.articles');
    Route::get(config('modules.articles.route') .'/{category}/{article}')->uses('FrontendController@viewArticle')->name('article.view');
