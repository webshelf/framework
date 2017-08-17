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
    Route::get('/admin/accounts')                       ->uses('Controller@index')         ->name('accounts');
    Route::get('/admin/accounts/{email')                ->uses('Controller@profile')       ->name('AccountProfile');
    Route::get('/admin/acounts/register')               ->uses('Controller@register')      ->name('RegisterAccount');
    Route::get('/admin/accounts/verify/{account_id}')   ->uses('Controller@verify')        ->name('AccountVerify');


    // Post Requests.
    // ==================================================================================
    Route::post('/admin/account/update')                ->uses('Controller@updateAccount') ->name('updateAccount');
    Route::post('/admin/accounts/register')             ->uses('Controller@registration')  ->name('AccountRegistration');
