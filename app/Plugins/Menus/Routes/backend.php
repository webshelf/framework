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

    Route::get('/admin/menus')->uses('BackendController@index')->name('menus');
    Route::get('/admin/menus/create')->uses('BackendController@create')->name('CreateMenu');
    Route::post('/admin/menus/make')->uses('BackendController@store')->name('MakeMenu');
    Route::get('/admin/menus/page')->uses('BackendController@page')->name('PageMenu');

    Route::get('/admin/menus/group/{group_id}')->uses('BackendController@index')->name('admin.menu.group');

    Route::post('/admin/menus/order')->uses('BackendController@ajax_order')->name('UpdateOrder');
    Route::post('/admin/menus/attach')->uses('BackendController@attach')->name('AttachMenu');
    Route::post('/admin/menus/update')->uses('BackendController@ajax_update')->name('UpdateMenu');
    Route::post('/admin/menus/delete/{id}')->uses('BackendController@ajax_delete')->name('DeleteMenu');

// Post Requests.
    // ==================================================================================
