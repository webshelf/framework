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
    foreach ($repository->allWithMenuAndParent() as $page) {
        if (! $page->redirect) {
            if ($page->plugin) {
                Route::get(makeSlug($page))->name($page->slug)->uses('App\Http\Controllers\PageController@index');
            } else {
                Route::get(makeSlug($page))->name($page->slug)->uses('App\Http\Controllers\PageController@index');
            }
        }
    }

    // Post Requests.
    // ==================================================================================
