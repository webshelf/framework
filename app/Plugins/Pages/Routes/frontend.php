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

    // Get Requests.
    // ==================================================================================

    /** @var \App\Classes\Repositories\PageRepository $repository */
    $repository = app(\App\Classes\Repositories\PageRepository::class);

    /** @var \App\Model\Page $page */
    foreach ($repository->frontendPageCollection() as $page) {
        if (! $page->redirect) {
            if ($page->plugin) {
                Route::get($page->route())->uses('App\Http\Controllers\PageController@index');
            } else {
                Route::get($page->route())->uses('App\Http\Controllers\PageController@index');
            }
        }
    }

    //Route::any('{menu}/{submenu}', function() { return redirect('/'); });

    // Post Requests.
    // ==================================================================================
