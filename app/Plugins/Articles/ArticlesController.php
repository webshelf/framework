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
use App\Plugins\Pages\Model\PageTypes;
use App\Plugins\Pages\Model\PageOptions;

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
        $page->title = 'articles';
        $page->identifier = 'articles';
        $page->type = PageTypes::TYPE_PLUGIN;
        $page->option = PageOptions::OPTION_PUBLIC;
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
        $pages = app(PageRepository::class);

        /** @var Page $page */
        $page = $pages->whereIdentifier('articles');

        // status of the operation.
        return $page->forceDelete();
    }
}
