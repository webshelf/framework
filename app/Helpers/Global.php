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
     * @deprecated 5.4 Use Config Provider from Laravel.
     *
     * @return \App\Classes\SettingsManager
     */
    function settings()
    {
        throw new Exception("Settings called...");
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

    /**
     * Easier font awesome icon handling, with conditional statemnet.
     *
     * @param string $icon The icon to use if the condition is true or no condition is giving.
     * @param string $opposite The icon to use if the condition is false.
     * @param bool $condition The condition to check on icon to be used.
     * @return string
     */
    function useIcon(string $icon, string $opposite = '', bool $condition = true)
    {
        if ($condition == false) {
            return "<i class='fas fa-{$opposite}'></i>";
        }

        return "<i class='fas fa-{$icon}'></i>";
    }

    /**
     * Return a selector string for form selections, This allows smaller coding.
     *
     * @param mixed $value The value to check that matches the matches.
     * @param mixed $matches The value we want to compare against.
     * @return string The selected match query.
     */
    function formSelect($value, $matches)
    {
        return $value == $matches ? 'selected' : '';
    }
