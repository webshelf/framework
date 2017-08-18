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
    Route::get('/admin/products')                       ->uses('BackendController@index')       ->name('ProductIndex');
    Route::get('/admin/products/{plugin}/status')       ->uses('BackendController@index')       ->name('ProductStatus');

    // Post Requests.
    // ==================================================================================

