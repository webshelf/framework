<?php

namespace App\Plugins\Pages\Model;

/**
 * Page Types Class Contstant Values.
 */
class PageOptions
{
    /*
    |--------------------------------------------------------------------------
    | Options None
    |--------------------------------------------------------------------------
    |
    | This allows for a default value to exist in the database since we use
    | binary data storage.
    |
    */
    const OPTION_DEFAULT = 0;
    /*
    |--------------------------------------------------------------------------
    | Visibility Public
    |--------------------------------------------------------------------------
    |
    | The page can be accessed by public visitors.
    |
    */
    const OPTION_PUBLIC = 1;

    /*
    |--------------------------------------------------------------------------
    | Enable Sitemap
    |--------------------------------------------------------------------------
    |
    | This allows the page to be stored on the sitemap for SEO.
    |
    */
    const OPTION_SITEMAP = 2;

    /*
    |--------------------------------------------------------------------------
    | Hidden Page
    |--------------------------------------------------------------------------
    |
    | This will not be shown to users on the dashboard and essentially,
    | does not exist outside of the database.
    |
    */
    const OPTION_HIDDEN = 4;
}
