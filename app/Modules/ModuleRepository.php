<?php

namespace App\Modules;

use Larapack\ConfigWriter\Repository;

/**
 * Class ConfigRepository
 *
 * @package App\Modules\Configs
 */
class ModuleRepository extends Repository
{

    /**
     * ConfigRepository constructor.
     */
    public function __construct()
    {
        parent::__construct('modules');
    }

    /**
     * Return the repository to chain a set and save.
     *
     * @param array|string $key
     * @param null $value
     *
     * @return $this
     * @throws ModuleNotFoundException
     */
    public function set($key, $value = null)
    {
        parent::set($key, $value);

        return $this;
    }

    /**
     * Save the current configuration to file.
     *
     * @param null $from
     * @param null $to
     * @param bool $validate
     * @return bool
     *
     */
    public function save($from = null, $to = null, $validate = true)
    {
        parent::save($from, $to, $validate);

        return true;
    }
}