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
    Route::get('/admin/redirects', ['as'   => 'redirects',         'uses'=>adminPluginController('redirects', 'index')]);
    Route::get('/admin/redirects/make', ['as'   => 'MakeRedirect',      'uses'=>adminPluginController('redirects', 'store')]);
    Route::post('/admin/redirects/create', ['as'   => 'CreateRedirect',    'uses'=>adminPluginController('redirects', 'create')]);
    Route::post('/admin/redirect/delete/{id}', ['uses'=> adminPluginController('redirects', 'ajaxDeleteID')]);

    // Post Requests.
    // ==================================================================================
