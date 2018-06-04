<?php

namespace App\Plugins\Pages\Model;

/**
 * Page Types Class Contstant Values.
 */
class PageTypes
{
    /*
    |--------------------------------------------------------------------------
    | Type Standard
    |--------------------------------------------------------------------------
    |
    | Used to define a normal loading page that can be created by the
    | user on the dashboard.
    |
    */
    const TYPE_STANDARD = 1;

    /*
    |--------------------------------------------------------------------------
    | Type Plugin
    |--------------------------------------------------------------------------
    |
    | Plugins are non-static entities that can be switched out and in by the
    | user, these can be removed and added on the fly.
    |
    */
    const TYPE_PLUGIN = 2;

    /*
    |--------------------------------------------------------------------------
    | Type Module
    |--------------------------------------------------------------------------
    |
    | These will coexist with any modules that we may build in the future?
    |
    */
    const TYPE_MODULE = 4;

    /*
    |--------------------------------------------------------------------------
    | Type Framework
    |--------------------------------------------------------------------------
    |
    | Framework Pages are REQUIRED for the operation of the website to
    | exist, these can not be deleted, or made editable.
    |
    */
    const TYPE_FRAMEWORK = 8;

    /*
    |--------------------------------------------------------------------------
    | Type Error
    |--------------------------------------------------------------------------
    |
    | These pages are similiar to special however they will by used by
    | error handlers such as 404, restrictions may be applied.
    |
    */
    const TYPE_ERROR = 16;
}