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

    Route::get('/admin/pages/special')->uses('BackendController@indexSpecial')->name('admin.pages.special');
    Route::get('/admin/pages/normal')->uses('BackendController@index')->name('admin.pages.index');


    Route::resource('admin/pages', 'BackendController', ['as' => 'admin', 'except' => ['index']]);
    // Allow destruction without using forms.
    Route::get('/admin/pages/destroy/{slug}')->uses('BackendController@destroy')->name('admin.pages.destroy');
