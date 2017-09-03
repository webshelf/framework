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

    Route::get('/admin/redirects')->uses('BackendController@index')->name('redirects');
    Route::get('/admin/redirects/make')->uses('BackendController@store')->name('MakeRedirect');
    Route::post('/admin/redirects/create')->uses('BackendController@created')->name('CreateRedirect');
    Route::post('/admin/redirect/delete/{id}')->uses('BackendController@ajaxDeleteID');
