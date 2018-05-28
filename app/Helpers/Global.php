<?php

use Illuminate\Support\Debug\Dumper;

    /**
     * Return the auth account instance class.
     *
     * @return \App\Model\Account|\Illuminate\Contracts\Auth\Authenticatable
     */
    function account()
    {
        return auth()->user();
    }

    /**
     * Return the webshelf framework version.
     *
     * @return App\Framework
     */
    function framework()
    {
        return app(App\Framework::class);
    }

    /**
     * @return \App\Classes\SettingsManager
     */
    function settings()
    {
        return app(\App\Classes\SettingsManager::class);
    }

    /**
     * @return \App\Classes\PluginManager
     */
    function plugins()
    {
        return app(\App\Classes\PluginManager::class);
    }

    /**
     * @return \App\Classes\Library\StyleCSS\Style
     */
    function css()
    {
        return app(\App\Classes\Library\StyleCSS\Style::class);
    }

    /**
     * Returned the morphed model.
     *
     * @param string $table
     * @param int $id
     * @return App\Classes\Interfaces\Linkable
     */
    function getMorphedModel(string $table, int $id)
    {
        return app($table)->whereKey($id)->first();
    }

    /**
     * @return string
     */
    function currentURI()
    {
        $route = basename(request()->path()) ?: 'index';

        return $route != '' ? $route : 'index';
    }

    /**
     * Return an array of the segmented url path.
     *
     * @return array
     */
    function segmentRequestPath()
    {
        $path = app('request')->path();

        if ($path == '/') {
            return ['index'];
        }

        return explode('/', $path);
    }

    /**
     * Turn a boolean value into readable data.
     * true  = Active
     * false = Inactive.
     *
     * @param $boolean
     * @param null $trueMessage
     * @param null $falseMessage
     * @return string
     * @internal param null $true
     * @internal param null $false
     * @deprecated
     */
    function bool2Status($boolean, $trueMessage = null, $falseMessage = null)
    {
        if ($boolean == true) {
            return '<span class="status green">'.($trueMessage ?: 'Active').'</span>';
        } else {
            return '<span class="status red">'.($falseMessage ?: 'Inactive').'</span>';
        }
    }

     /**
     * Dump the object information without halting execution.
     *
     * @param  mixed  $args
     * @return void
     */
    function debugVar(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
    }