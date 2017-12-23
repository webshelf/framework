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

    Route::resource('admin/pages', 'BackendController', ['as' => 'admin']);

    // Allow destruction without using forms.
    Route::get('/admin/pages/destroy/{slug}')->uses('BackendController@destroy')->name('admin.pages.destroy');
