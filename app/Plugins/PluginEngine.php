<?php

namespace App\Plugins;

use App\Model\Plugin;
use App\Http\Controllers\Controller;
use App\Classes\Repositories\PluginRepository;

/**
 * Class PluginEngine.
 */
abstract class PluginEngine extends Controller
{
    /**
     * Return the stored module name.
     *
     * @return string
     */
    private $pluginName;

    /**
     * Locate the blade template from the modules folder.
     *
     * @param string $blade_template
     * @return \Illuminate\Contracts\View\View
     */
    public function make(string $blade_template)
    {
        return view()->make(sprintf('plugins::%s.blade.%s', $this->pluginName(), $blade_template));
    }

    /**
     * Get the module name by checking the class name location.
     *
     * @return mixed
     */
    private function pluginName()
    {
        if($this->pluginName)
            return $this->pluginName;

        return $this->pluginName = explode('\\', get_class($this))[2];

    }

    /**
     * Redirect to a plugin view location.
     * For ajax return calls.
     *
     * @param $blade_template
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirect($blade_template)
    {
        return redirect()->intended($this->pluginName().'::'.$blade_template);
    }

    /**
     * @todo what does this do and document it.
     *
     * @return Plugin|array|\stdClass
     */
    protected function pluginData()
    {
        return (new PluginRepository(new Plugin))->whereName($this->pluginName());
    }
}
