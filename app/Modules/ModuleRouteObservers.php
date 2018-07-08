<?php

namespace App\Modules;

use App\Model\Page;
use App\Modules\Pages\Model\PageTypes;

/**
 * Class ModuleObservers.
 */
class ModuleRouteObservers
{
    /**
     * @var ModuleManager
     */
    protected $module;

    /**
     * ModuleObservers constructor.
     *
     * @param ModuleManager $module
     */
    public function __construct(ModuleManager $module)
    {
        $this->module = $module;
    }

    /**
     * Handle pages that have been updated.
     *
     * @param Page $page
     *
     * @return void
     * @throws ModuleNotFoundException
     */
    public function updated(Page $page)
    {
        $this->updateModuleRoute($page);
    }

    /**
     * Handle pages that have been created.
     *
     * @param Page $page
     *
     * @throws ModuleNotFoundException
     */
    public function created(Page $page)
    {
        $this->updateModuleRoute($page);
    }

    /**
     * Check if the page is type router.
     *
     * @param Page $page
     *
     * @return int
     */
    private function isTypeRouter(Page $page): int
    {
        return $page->type & PageTypes::TYPE_ROUTER;
    }

    /**
     * Update the modules route on the configuration file.
     *
     * @param Page $page
     * @throws ModuleNotFoundException
     */
    public function updateModuleRoute(Page $page)
    {
        if ($this->isTypeRouter($page)) {
            $this->module->route($page->module, $page->slug);
        }
    }
}
