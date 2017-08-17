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

    Route::post('/admin/login', ['as' => 'AuthLogin',           'uses' => 'AuthController@login']);
    Route::post('/contact', ['as' => 'ContactUs',           'uses' => 'EmailController@SendContactInfo']);
    Route::post('/admin/upload/image/{path?}', ['as' => 'ImageUpload',         'uses' => 'Controller@ajaxSingleUpload']);
/*
|--------------------------------------------------------------------------
| Glide Image Manipulation
|--------------------------------------------------------------------------
|
| 3rd party app link, glide for elfinder.
|
*/

//Route::get('glide/{path}', function($path){
//        $server = \League\Glide\ServerFactory::create([
//            'source' => app('filesystem')->disk('public')->getDriver(),
//            'cache' => storage_path('glide'),
//        ]);
//        return $server->getImageResponse($path, Input::query());
//    })->where('path', '.+');
