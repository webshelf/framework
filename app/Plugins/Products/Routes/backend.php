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
    Route::get('/admin/products')->uses('BackendController@index')->name('products.index');

    /**
     * Login for plugins.
     */
    Route::get('/admin/products/install/{plugin}')->uses('BackendController@install')->name('products.install');
    Route::get('/admin/products/uninstall/{plugin}')->uses('BackendController@uninstall')->name('products.uninstall');