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
    Route::get('/admin/products', 'BackendController@index')->name('admin.products.index');
    Route::get('/admin/products/{module}/toggle', 'BackendController@toggle')->name('admin.products.toggle');
