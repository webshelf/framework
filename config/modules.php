<?php

return [

    'products' => [
        'title' => 'Products',
        'enabled' => true,
        'icon' => 'fas fa-box',
        'version' => 1.0,
        'url' => 'admin/products',
        'role' => 'publisher',
    ],

    'navigation' => [
        'title' => 'Navigation',
        'enabled' => true,
        'icon' => 'fas fa-compass',
        'version' => 1.0,
        'url' => 'admin/navigation',
        'role' => 'publisher',
    ],

    'pages' => [
        'title' => 'Pages',
        'enabled' => true,
        'icon' => 'fab fa-readme',
        'version' => 1.0,
        'url' => 'admin/pages',
        'role' => 'publisher',
    ],

    'redirects' => [
        'title' => 'Redirects',
        'enabled' => false,
        'icon' => 'fas fa-exchange-alt',
        'version' => 1.0,
        'url' => 'admin/redirects',
        'role' => 'publisher',
    ],

    'articles' => [
        'title' => 'Articles',
        'enabled' => true,
        'icon' => 'fas fa-glasses',
        'version' => 1.0,
        'url' => 'admin/articles',
        'role' => 'publisher',
        'route' => 'articles',
    ],

    'newsletters' => [
        'title' => 'Newsletters',
        'enabled' => false,
        'icon' => 'fa-book',
        'version' => 1.0,
        'url' => 'admin/newsletter',
        'role' => 'publisher',
    ],

    'settings' => [
        'title' => 'Settings',
        'enabled' => true,
        'icon'  => 'fas fa-wrench',
        'version' => 1.0,
        'url'   => 'admin/settings',
        'role'  => 'administrator',
    ],

    'accounts' => [
        'title' => 'Accounts',
        'enabled' => true,
        'icon'  => 'fa fa-users',
        'version' => 1.0,
        'url'   => 'admin/accounts',
        'role'  => 'administrator',
    ],

    'filemanager' => [
        'title'   => 'Filemanager',
        'enabled' => true,
        'icon'    => 'fas fa-toolbox',
        'version' => 1.0,
        'url'     => 'admin/filemanager',
        'role'    => 'publisher',
    ],

    'updates' => [
        'title' => 'Updates',
        'enabled' => true,
        'icon'  => 'fas fa-code',
        'version' => 1.0,
        'url'   => 'admin/updates',
        'role'  => 'developer',
    ],

    'sitemap' => [
        'title' => 'Sitemap',
        'enabled' => true,
        'icon'  => 'fas fa-globe',
        'version' => 1.0,
        'url'   => 'admin/sitemap',
        'role'  => 'developer',
    ],

];
