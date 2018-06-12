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

    // page types.
    Route::get('/admin/pages/plugin')->uses('BackendController@indexPlugin')->name('admin.pages.plugin');
    Route::get('/admin/pages/error')->uses('BackendController@indexError')->name('admin.pages.error');
    Route::get('/admin/pages/normal')->uses('BackendController@index')->name('admin.pages.index');

    // resource.
    Route::resource('admin/pages', 'BackendController', ['as' => 'admin']);
