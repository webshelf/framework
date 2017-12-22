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

    Route::resource('admin/redirects', 'BackendController', ['as' => 'admin']);

    // Allow destruction without using X-CSRF.
    Route::get('/admin/redirects/destroy/{menu_id}')->uses('BackendController@destroy')->name('admin.redirects.destroy');
