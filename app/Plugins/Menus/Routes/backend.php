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

    Route::resource('admin/menus', 'BackendController', ['as' => 'admin']);

    // Allow destruction without using forms.
    Route::get('/admin/menus/destroy/{menu_id}')->uses('BackendController@destroy')->name('admin.menus.destroy');

    // Allows groupings on the index.
    Route::get('/admin/menus/group/{group_id}')->uses('BackendController@index')->name('admin.menus.group');
    

    // Post Requests.
    // ==================================================================================
