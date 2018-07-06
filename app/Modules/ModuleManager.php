<?php

namespace App\Modules;

use App\Model\Page;

/**
 * Class ModuleLoader.
 */
class ModuleManager
{
    /**
     * @var ModuleRepository
     */
    private $repository;

    /**
     * ModuleLoader constructor.
     *
     * @param ModuleRepository $repository
     */
    public function __construct(ModuleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Enable a module using the modules.php configuration.
     *
     * @param string $module
     *
     * @return $this
     *
     * @throws ModuleNotFoundException
     */
    public function enable(string $module)
    {
        $this->repository->set("{$module}.enabled", true)->save();

        $this->updatePageBelongingTo($module, $this->repository->get("{$module}.enabled"));
    }

    /**
     * @param string $module
     * @return $this
     * @throws ModuleNotFoundException
     */
    public function disable(string $module)
    {
        $this->repository->set("{$module}.enabled", false)->save();

        $this->updatePageBelongingTo($module, $this->repository->get("{$module}.enabled"));
    }

    /**
     * Toggle the status of a module in the configuration.
     *
     * @param string $module
     *
     * @return $this
     * @throws \App\Modules\ModuleNotFoundException
     */
    public function toggle(string $module)
    {
        $this->repository->set("{$module}.enabled", ! $this->repository->get("{$module}.enabled"))->save();

        $this->updatePageBelongingTo($module, $this->repository->get("{$module}.enabled"));
    }

    /**
     * Get the status of a module from the module repository, including the new values if it was set.
     *
     * @param string $module
     *
     * @return mixed
     */
    public function status(string $module)
    {
        return $this->repository->get("{$module}.enabled");
    }

    /**
     * Sync the module pages to load with the condig status.
     *
     * @param $module
     * @param bool $status
     *
     * @return void
     */
    private function updatePageBelongingTo($module, bool $status)
    {
        Page::toggleModuleDisability($module, $status);
    }
}
