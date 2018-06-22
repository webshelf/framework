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
    $page = Page::whereIdentifier('articles');

    /*
    |--------------------------------------------------------------------------
    | (Page Path = Articles Page '/articles')
    |--------------------------------------------------------------------------
    */
    Route::get($page->path())->uses('App\Plugins\Articles\FrontendController@allArticles')->name('articles.index');
    Route::get($page->path().'/search')->uses('App\Plugins\Articles\FrontendController@searchArticles')->name('articles.search');

    Route::get($page->path().'/{category}')->uses('App\Plugins\Articles\FrontendController@allArticlesInCategory')->name('category.articles');
    Route::get($page->path().'/{category}/{article}')->uses('App\Plugins\Articles\FrontendController@viewArticle')->name('articles.view');
    
    Route::get($page->route().'/creator/{id}')->uses('App\Plugins\Articles\FrontendController@creator')->name('articles.creator');
