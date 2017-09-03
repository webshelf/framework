<?php

    function dumpVar()
    {
        array_map(function ($x) {
            (new \Illuminate\Support\Debug\Dumper())->dump($x);
        }, func_get_args());
    }

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
     * Get the path to the dashboard folder.
     *
     * @param  string  $path
     * @return string
     */
    function dashboard_path($path = '')
    {
        return app()->make('path.dashboard').($path ? DIRECTORY_SEPARATOR.$path : $path);
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
     * @return \App\Classes\PopupQueue
     */
    function popups()
    {
        return app(App\Classes\PopupQueue::class);
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

    function makeSlug(\App\Model\Page $page)
    {
        try {
            if ($page->menu) {
                if ($page->menu->parent) {
                    return $page->menu->parent->slug.'/'.$page->slug;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Unexpected error occurred for url creation of the page '.$page->slug);
        }

        return $page->slug;
    }

    function makeUrl(\App\Model\Page $page)
    {
        return url(makeSlug($page));
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
     */
    function bool2Status($boolean, $trueMessage = null, $falseMessage = null)
    {
        if ($boolean == true) {
            return '<span class="status green">'.($trueMessage ?: 'Active').'</span>';
        } else {
            return '<span class="status red">'.($falseMessage ?: 'Inactive').'</span>';
        }
    }

    function currentURI()
    {
        $route = basename(request()->path()) ?: 'index';

        return $route != '' ? $route : 'index';
    }
