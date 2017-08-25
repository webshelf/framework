<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/05/2016
 * Time: 22:27.
 */

namespace App\Plugins\News;

use App\Plugins\PluginEngine;
use App\Classes\SitemapGenerator;
use App\Classes\Interfaces\Sitemap;
use App\Http\Controllers\Controller;
use App\Classes\Repositories\PageRepository;
use App\Classes\Interfaces\FeedableInterface;
use App\Classes\Repositories\ArticleRepository;

/**
 * Class UserController.
 *
 * News controller loads front end view for the user.
 */
class FrontendController extends PluginEngine implements Sitemap, FeedableInterface
{
    /**
     * @param FrontPageLoader $load
     * @param PageRepository $page
     * @param ArticleRepository $news
     * @return $this
     * @internal param FrontPageLoader $loader
     */
    public function index(FrontPageLoader $load, PageRepository $page, ArticleRepository $news)
    {
        return $load->model($page->whereName('news'))->with('news.articles', $news->paginateEnabled(7))->loadNormal(true)->view('index');
    }

    /**
     * The sitemap function allows plugins to quickly and effectively
     * create and store new content for the SEO Sitemap Controller.
     *
     * @param SitemapGenerator $sitemap
     * @return mixed
     */
    public function sitemap(SitemapGenerator $sitemap)
    {
        return $sitemap;
    }

    /**
     * Feeds if enabled should be sent
     * to the page on every load request.
     *
     * @param $size
     * @return mixed
     */
    public function feed($size)
    {
        return ArticleRepository::all();
    }
}
