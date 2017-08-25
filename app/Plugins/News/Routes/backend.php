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

    // Get Requests.
    // ==================================================================================

    Route::get('/admin/news')->uses('BackendController@index')->name('news');
    Route::get('/admin/news/create')->uses('BackendController@create')->name('CreateNews');
    Route::post('/admin/news/store')->uses('BackendController@store')->name('StoreNews');
    Route::get('/edit/news/{slug}')->uses('BackendController@edit')->name('EditNews');
    Route::post('/edit/news/{slug}')->uses('BackendController@update')->name('UpdateNews');

    // Post Requests.
    // ==================================================================================
