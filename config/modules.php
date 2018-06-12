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
        'title' => 'Updates',
        'icon'  => 'fa fa-history',
        'url'   => 'admin/updates',
        'role'  => '',
    ],

    [
        'title' => 'Sitemap',
        'icon'  => 'fa fa-sitemap',
        'url'   => 'admin/sitemap',
        'role'  => '',
    ],
    
    [
        'title' => 'Accounts',
        'icon'  => 'fa fa-users',
        'url'   => 'admin/accounts',
        'role'  => 'configure',
    ],

    [
        'title' => 'Settings',
        'icon'  => 'fa fa-cogs',
        'url'   => 'admin/settings',
        'role'  => 'configure',
    ],


    [
        'title'   => 'Filemanager',
        'icon'    => 'fa fa-microchip',
        'url'     => 'admin/filemanager',
        'role'    => '',
    ],

];
