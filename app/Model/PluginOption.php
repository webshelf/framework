<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/09/2016
 * Time: 18:41.
 */

namespace App\Model;

/**
 * Class PluginOption.
 */
class PluginOption extends Engine
{
    protected $table = 'plugin_options';

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->getAttribute('key');
    }

    /**
     * @param string $string
     * @return $this
     */
    public function setKey(string $string)
    {
        $this->setAttribute('key', $string);

        return $this;
    }

    /**
     * @return int
     */
    public function value()
    {
        return $this->getAttribute('value') ?: 0;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function setValue(string $string)
    {
        $this->setAttribute('value', $string);

        return $this;
    }
}
