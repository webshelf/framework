<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Module Route Loading
    |--------------------------------------------------------------------------
    |
    | These are separated components in a form of modularity.
    | Upon production environments these will all be cached
    | allowing these to be loading one time per update.
    |
    */

    Route::post('/newsletter/join')->uses('FrontendController@joinNewsletter')->name('newsletter.join');

    Route::get('/newsletter/complete')->uses('FrontendController@completedNewsletter')->name('newsletter.complete');
    Route::get('/newsletter/failure')->uses('FrontendController@completedNewsletter')->name('newsletter.failure');
