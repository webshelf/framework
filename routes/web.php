<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get('/', ['as' => 'index',            'uses' => 'PageController@view']);
    Route::get('/admin', ['as' => 'dashboard',           'uses' => 'DashboardController@overview']);
    Route::get('/admin/login', ['as' => 'login',               'uses' => 'AuthController@form']);
    Route::get('/admin/logout', ['as' => 'AuthLogout',          'uses' => 'AuthController@logout']);
    Route::get('/admin/updates', ['as' => 'updates',             'uses' => 'UpdatesController@index']);
    Route::get('/admin/settings', ['as' => 'settings',            'uses' => 'SettingsController@edit']);
    Route::get('/sitemap.xml', ['as' => 'sitemap',             'uses' => 'SitemapController@all']);
    Route::get('/admin/sitemap', ['as' => 'sitemap.iframe',      'uses' => 'SitemapController@iframe']);
    Route::get('/admin/accounts', ['as' => 'accounts',            'uses' => 'AccountsController@index']);
    Route::get('/admin/accounts/register', ['as' => 'RegisterAccount',     'uses' => 'AccountsController@register']);
    Route::get('/admin/accounts/verify/{account_id}', ['as' => 'AccountVerify',       'uses' => 'AccountsController@verify']);
    Route::get('/admin/accounts/{email}', ['as' => 'AccountProfile',      'uses' => 'AccountsController@profile']);

    Route::post('/admin/login', ['as' => 'AuthLogin',           'uses' => 'AuthController@login']);
    Route::post('/admin/settings/save', ['as' => 'SaveSettings',        'uses' => 'SettingsController@save']);
    Route::post('/contact', ['as' => 'ContactUs',           'uses' => 'EmailController@SendContactInfo']);
    Route::post('/admin/upload/image/{path?}', ['as' => 'ImageUpload',         'uses' => 'ImageController@ajaxSingleUpload']);
    Route::post('/admin/accounts/register', ['as' => 'AccountRegistration', 'uses' => 'AccountsController@registration']);
    Route::post('/admin/account/update', ['as' => 'UpdateAccount',       'uses' => 'AccountsController@updateAccount']);

    /*
    |--------------------------------------------------------------------------
    | Glide Image Manipulation
    |--------------------------------------------------------------------------
    |
    | 3rd party app link, glide for elfinder.
    |
    */

    Route::get('glide/{path}', function($path){
        $server = \League\Glide\ServerFactory::create([
            'source' => app('filesystem')->disk('public')->getDriver(),
            'cache' => storage_path('glide'),
        ]);
        return $server->getImageResponse($path, Input::query());
    })->where('path', '.+');
