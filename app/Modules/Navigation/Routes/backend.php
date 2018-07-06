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

    Route::resource('admin/navigation', 'BackendController', ['as' => 'admin']);

    // Ajax reorder.
    Route::post('/admin/menus/reorder/')->uses('BackendController@reorder')->name('admin.navigation.reorder');

    // Allows groupings on the index.
    Route::get('/admin/menus/group/{group_id}')->uses('BackendController@index')->name('admin.navigation.group');

    // Post Requests.
    // ==================================================================================
