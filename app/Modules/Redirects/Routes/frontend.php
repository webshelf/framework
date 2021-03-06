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

    /** @var App\Classes\Repositories\RedirectRepository $repository */
    $repository = app(App\Classes\Repositories\RedirectRepository::class);

    foreach ($repository->all() as $redirect) {
        Route::get($redirect->from(), 'App\Http\Controllers\PageController@redirect');
    }
