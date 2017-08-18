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

    Route::get('/admin/pages')                        ->uses('BackendController@index')       ->name('pages');
    Route::get('/admin/pages/edit/{name}')            ->uses('BackendController@edit')        ->name('EditPage');
    Route::get('/admin/pages/create')                 ->uses('BackendController@create')      ->name('CreatePage');

    // Post Requests.
    // ==================================================================================
    Route::post('/admin/pages/save/{name}')           ->uses('BackendController@save')        ->name('SavePage');
    Route::post('/admin/pages/make')                  ->uses('BackendController@store')       ->name('MakePage');
    Route::post('/admin/pages/delete/{name}')         ->uses('BackendController@delete')      ->name('DeletePage');


