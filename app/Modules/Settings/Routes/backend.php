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
    Route::get('/admin/settings')->uses('Controller@index')->name('admin.settings.index');

    // Post Requests.
    // ==================================================================================
    Route::post('/admin/settings/update')->uses('Controller@update')->name('admin.settings.update');
