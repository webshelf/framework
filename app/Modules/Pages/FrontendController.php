<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/05/2016
 * Time: 22:27.
 */

namespace App\Modules\Pages;

use App\Model\Page;
use App\Jobs\IncrementViews;
use App\Modules\ModuleEngine;
use App\Classes\SitemapGenerator;
use App\Classes\Interfaces\Sitemap;
use App\Classes\Repositories\PageRepository;
use App\Classes\Library\PageLoader\Frontpage;

/**
 * Class UserController.
 */
class FrontendController extends ModuleEngine implements Sitemap
{
    /**
     * @var Page
     */
    private $currentPage;

    /**
     * PageController constructor.
     * @param PageRepository $pages
     */
    public function __construct(PageRepository $pages)
    {
        $this->currentPage = $pages->whereName(currentURI());
    }

    /**
     * Redirects must use a controller to handle the parameter, as they require a specified target.
     * @return mixed
     */
    public function redirect()
    {
        return redirect($this->currentPage->redirect->to(), 302);
    }

    /**
     * Standard page views are once that use the URL as the designated target.
     *
     * @return mixed
     * @throws \Exception
     * @internal param FrontPageLoader $pageLoader
     */
    public function index()
    {
        IncrementViews::dispatch($this->currentPage);

        return Frontpage::build($this->currentPage);
    }

    /**
     * The sitemap function allows plugins to quickly and effectively
     * create and store new content for the SEO Sitemap Controller.
     *
     * @param SitemapGenerator $sitemap
     * @return SitemapGenerator
     */
    public function sitemap(SitemapGenerator $sitemap)
    {
        /** @var PageRepository $repository */
        $repository = app(PageRepository::class);

        /** @var Page $page */
        foreach ($repository->whereSitemap() as $page) {
            $sitemap->store(url($page->route()), $page->updated_at, 'bi-weekly', '1.0');
        }

        return $sitemap;
    }
}
