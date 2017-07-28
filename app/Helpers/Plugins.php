<?php

// NEW PLUGIN ROUTE FUNCTIONS - 20TH MAY 2016.
// MORE CONSISTENT AND BETTER READING + USAGE.

    /**
     * Function that allows you to create a direct route to the plugins
     * user controller for front end actions and viewing.
     *
     * @param $plugin
     * @param null $method
     * @param bool $stringify
     * @return string
     * @throws Exception
     */
    function userPluginController($plugin, $method = null, $stringify = false)
    {
        if ($method != null) {
            return 'App\Plugins\\'.ucfirst($plugin).'\UserController@'.$method;
        } else {
            $controller = 'App\Plugins\\'.ucfirst($plugin).'\UserController';

            if (class_exists($controller)) {
                return $stringify ? $controller : app($controller);
            }

            return $controller;
        }
    }

    /**
     * Function that allows you to create a direct route to the plugins
     * admin controller for back end actions and action viewing.
     *
     * @param $plugin
     * @param null $method
     * @param bool $stringify
     * @return string
     * @throws Exception
     */
    function adminPluginController($plugin, $method = null, $stringify = false)
    {
        if ($method != null) {
            return 'App\Plugins\\'.ucfirst($plugin).'\AdminController@'.$method;
        } else {
            $controller = 'App\Plugins\\'.ucfirst($plugin).'\AdminController';

            if (class_exists($controller)) {
                return $stringify ? $controller : app($controller);
            }

            return $controller;
        }
    }
