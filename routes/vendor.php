<?php

use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Elfinder routes.
    |--------------------------------------------------------------------------
    |
    | Define the routes for the elfinder connectivity.
    |
    */
    Route::get('elfinder')->uses('Barryvdh\Elfinder\ElfinderController@showIndex')->name('elfinder')->middleware('auth');
    Route::any('elfinder/connector')->uses('Barryvdh\Elfinder\ElfinderController@showConnector')->name('elfinder.connector')->middleware('auth');

    Route::get('elfinder/tinymce', 'Barryvdh\Elfinder\ElfinderController@showTinyMCE4')->middleware('auth');
    Route::get('elfinder/popup/{input_id}', 'Barryvdh\Elfinder\ElfinderController@showPopup')->middleware('auth');
