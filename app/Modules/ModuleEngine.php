<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 17/08/2017
 * Time: 15:38.
 */

namespace App\Modules;

use App\Http\Controllers\Controller;

/**
 * Class ModuleEngine.
 */
abstract class ModuleEngine extends Controller
{
    /**
     * Return the stored module name.
     *
     * @return string
     */
    private $moduleName;

    /**
     * Locate the blade template from the modules folder.
     *
     * @param string $blade_template
     * @return \Illuminate\Contracts\View\View
     */
    public function make(string $blade_template)
    {
        return view()->make(sprintf('modules::%s.Blade.%s', $this->moduleName(), $blade_template));
    }

    /**
     * Get the module name by checking the class name location.
     *
     * @return mixed
     */
    private function moduleName()
    {
        if ($this->moduleName) {
            return $this->moduleName;
        }

        return $this->moduleName = explode('\\', get_class($this))[2];
    }
}
