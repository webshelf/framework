<?php

return [

    /*
     |--------------------------------------------------------------------------
     | HTML TAG ELEMENTS.
     |--------------------------------------------------------------------------
     |
     | This configuration controls the html tags that appear on every page header.
     |
     */
    'tag' => [
        'title' => [
            'text' => '',
            'position' => 'left',
            'seperator' => '-',
        ],
        'keywords' => [
            'default' => '',
        ],
        'description' => [
            'default' => '',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */
    'contact' => [
        'address' => '',
        'phone' => '',
        'email' => '',
        'fax' => '',
    ],

    'webmaster' => [
        'google' => [
            'tracking' => '',
        ],
    ],
];
