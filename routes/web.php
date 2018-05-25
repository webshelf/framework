<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Page Access
    |--------------------------------------------------------------------------
    |
    | Pages are handled dynamically by the Pages Plugin.
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    Route::get('/')->uses('PageController@index')->name('index');

    /*
    |--------------------------------------------------------------------------
    | Dashboard Access
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    Route::get('/admin')->uses('DashboardController@index')->name('dashboard')->middleware('auth');

    /*
    |--------------------------------------------------------------------------
    | Login Form
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    Route::get('/admin/login')->uses('AuthController@form')->name('login');

    /*
    |--------------------------------------------------------------------------
    | Authentication Access
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    Route::post('/admin/login')->uses('AuthController@login')->name('AuthLogin');

    /*
    |--------------------------------------------------------------------------
    | Dismantle session and user authentication.
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    Route::get('/admin/logout')->uses('AuthController@logout')->name('AuthLogout');
