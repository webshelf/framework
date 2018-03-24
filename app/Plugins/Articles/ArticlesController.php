<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 23/01/2018
 * Time: 15:14.
 */

namespace App\Plugins\Articles;

use App\Model\Page;
use App\Plugins\PluginHandler;
use App\Classes\Interfaces\Installable;
use App\Classes\Repositories\PageRepository;

/**
 * Class ArticleController.
 */
class ArticlesController extends PluginHandler implements Installable
{
    /**
     * Return the icon associated with this plugin.
     */
    public function icon()
    {
        return 'fa-file-text';
    }

    /**
     * Return the version for this plugin.
     */
    public function version()
    {
        return '1.1';
    }

    /**
     * The steps required for this plugin product to fully
     * integrate into the webservice.
     *
     * @return bool
     */
    public function install()
    {
        /** @var Page $page */
        $page = app(Page::class);

        $page->seo_title = 'News';
        $page->slug = 'news';
        $page->enabled = true;
        $page->sitemap = false;
        $page->plugin = $this->pluginName();

        // status of the operation
        return $page->save();
    }

    /**
     * The steps required for this plugin product to fully
     * remove itself from the webservice.
     *
     * @return bool
     * @throws \Exception
     */
    public function uninstall()
    {
        /** @var PageRepository $repository */
        $repository = app(PageRepository::class);

        /** @var Page $page */
        $page = $repository->wherePlugin($this->pluginName());

        // status of the operation.
        return $page->forceDelete();
    }
}
