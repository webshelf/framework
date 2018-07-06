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

    /** @var Page $page */
    $page = Page::whereIdentifier('articles');

    /*
    |--------------------------------------------------------------------------
    | (Page Path = Articles Page '/articles')
    |--------------------------------------------------------------------------
    */
    Route::get($page->path())->uses('FrontendController@allArticles')->name('articles.all');
    Route::get($page->path().'/search')->uses('FrontendController@searchArticles')->name('search.articles');
    Route::get($page->path().'/{category}')->uses('FrontendController@categoryArticles')->name('category.articles');
    Route::get($page->path().'/creator/{account}')->uses('FrontendController@allCreatorsArticles')->name('creator.articles');
    Route::get($page->path().'/{category}/{article}')->uses('FrontendController@viewArticle')->name('article.view');
