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
        'icon'  => 'fas fa-wrench',
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
        'icon'    => 'fas fa-toolbox',
        'url'     => 'admin/filemanager',
        'role'    => 'publisher',
    ],

    [
        'title' => 'Updates',
        'icon'  => 'fas fa-code',
        'url'   => 'admin/updates',
        'role'  => 'developer',
    ],

    [
        'title' => 'Sitemap',
        'icon'  => 'fas fa-globe',
        'url'   => 'admin/sitemap',
        'role'  => 'developer',
    ],
];
