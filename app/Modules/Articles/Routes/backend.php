<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Module Route Loading
    |--------------------------------------------------------------------------
    |
    | These are seperated components in a form of modularity.
    | Upon production environments these will all be cached
    | allowing these to be loading one time per update.
    |
    */
    Route::get('admin/articles/categories')->uses('BackendController@categories')->name('admin.articles.categories.index');
    Route::post('admin/articles/categories')->uses('BackendController@categories_store')->name('admin.articles.categories.store');
    Route::resource('admin/articles', 'BackendController', ['as' => 'admin']);