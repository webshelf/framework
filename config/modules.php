<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Core application menus that are used on the dashboard menu.
    |--------------------------------------------------------------------------
    |
    | From here you can enable or disable a menu and edit the configuration
    | this will allow the changes to be worked all throughout the dashboard.
    */

    [
        'title' => 'Settings',
        'icon'  => 'fa fa-cogs',
        'url'   => 'admin/settings',
        'role'  => 'administrator',
    ],

    [
        'title' => 'Accounts',
        'icon'  => 'fa fa-users',
        'url'   => 'admin/accounts',
        'role'  => 'administrator',
    ],

    [
        'title'   => 'Filemanager',
        'icon'    => 'fa fa-microchip',
        'url'     => 'admin/filemanager',
        'role'    => 'publisher',
    ],

    [
        'title' => 'Updates',
        'icon'  => 'fa fa-history',
        'url'   => 'admin/updates',
        'role'  => 'developer',
    ],

    [
        'title' => 'Sitemap',
        'icon'  => 'fa fa-sitemap',
        'url'   => 'admin/sitemap',
        'role'  => 'developer',
    ],
];
