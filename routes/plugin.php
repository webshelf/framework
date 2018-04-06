<?php

use App\Model\Plugin;
use App\Classes\Interfaces\RouteableInterface;

/*
    |--------------------------------------------------------------------------
    | Web Plugin Routes
    |--------------------------------------------------------------------------
    |
    | Front end routes or [isFrontEnd] & [UserPluginController] DO NOT REQUIRE AUTHENTICATION OR LOGIN TO VIEW.
    |
    | Back end routes or [isBackEnd] & [AdminPluginController] ALWAYS REQUIRES AUTHENTICATION OR A LOGIN TO BE VIEWED.
    |
    */

    /** @var Plugin $plugin */
    foreach (plugins()->getEnabled() as $plugin) {
        // does not require authentication.
        if ($plugin->isFrontEnd() && userPluginController($plugin->name()) instanceof RouteableInterface) {
            (userPluginController($plugin->name(), null, false))->routes(app('router'));
        }

        // requires authentication
        if ($plugin->isBackEnd() && adminPluginController($plugin->name()) instanceof RouteableInterface) {
            (adminPluginController($plugin->name(), null, false))->routes(app('router'));
        }
    }
