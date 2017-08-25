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
    Route::get('/admin/settings')->uses('Controller@edit')->name('settings');

    // Post Requests.
    // ==================================================================================
    Route::post('/admin/settings/save')->uses('Controller@save')->name('SaveSettings');
