<?php

use App\Model\Page;
use Illuminate\Support\Facades\Route;
use App\Classes\Repositories\PageRepository;

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

    /** @var Page $page */
    $page = app(PageRepository::class)->whereIdentifier('articles');

    // The articles page should route to the articles frontend controller handler.
    Route::get($page->route())->name('articles.index')->uses('App\Plugins\Articles\FrontendController@index');

    Route::get("{$page->route()}/{category}")->uses('App\Plugins\Articles\FrontendController@category');
    Route::get("{$page->route()}/{category}/{slug}")->uses('App\Plugins\Articles\FrontendController@article');

    Route::get($page->route().'/article/{id}')->name('articles.article')->uses('App\Plugins\Articles\FrontendController@article');
    Route::get($page->route().'/creator/{id}')->name('articles.creator')->uses('App\Plugins\Articles\FrontendController@creator');
    Route::get($page->route().'/category/{id}')->name('articles.category')->uses('App\Plugins\Articles\FrontendController@category');
    Route::get($page->route().'/search')->name('articles.search')->uses('App\Plugins\Articles\FrontendController@search');
