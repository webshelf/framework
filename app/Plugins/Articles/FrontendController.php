<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/05/2016
 * Time: 22:27.
 */

namespace App\Plugins\Articles;

use App\Model\Page;
use App\Model\Article;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use App\Classes\SitemapGenerator;
use App\Classes\Interfaces\Sitemap;
use Illuminate\View\Factory as View;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use App\Classes\Library\PageLoader\Frontpage;
use App\Classes\Repositories\ArticleRepository;

/**
 * Class UserController.
 */
class FrontendController extends PluginEngine implements Sitemap
{
    /**
     * @var View
     */
    private $view;

    /**
     * @var Page
     */
    private $currentPage;

    /**
     * PageController constructor.
     * @param PageRepository $pages
     * @param View $view
     */
    public function __construct(PageRepository $pages, View $view)
    {
        $this->view = $view;

        $this->currentPage = $pages->wherePlugin('Articles');
    }

    /**
     * @return mixed
     */
    private function navigationData()
    {
        return app(MenuRepository::class)->allParentsWithChildren();
    }

    /**
     * Usually the place for listing all the articles. (index).
     *
     * @param ArticleRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function index(ArticleRepository $repository)
    {
        $this->view->share('articles', $repository->paginateLatest(7));

        return $this->articleFrontPage();
    }

    public function article(ArticleRepository $repository, string $slug)
    {
        /** @var Article $article */
        $article = $repository->collectArticle($slug);

        $article->incrementView(1);

        $article->save();

        $this->currentPage->heading = $article->title;

        $this->view->share('articles', collect([0 => $article]));

        return $this->articleFrontPage();
    }

    public function search(ArticleRepository $repository, Request $request)
    {
        $this->view->share('articles', $repository->searchThenPaginate($request->get('search')));

        $this->currentPage->heading = 'Article Search';

        return $this->articleFrontPage();
    }

    public function category(ArticleRepository $repository, int $id)
    {
        $this->view->share('articles', $repository->whereCategoryId($id));

        $this->currentPage->heading = 'Browse Categories';

        return $this->articleFrontPage();
    }

    public function creator(ArticleRepository $repository, int $id)
    {
        $this->view->share('articles', $repository->whereCreatorId($id));

        $this->currentPage->heading = 'Browse Creators';

        return $this->articleFrontPage();
    }

    private function articleFrontPage()
    {
        return (new Frontpage($this->currentPage, $this->navigationData()))->publish('articles', false, 200);
    }

    /**
     * The sitemap function allows plugins to quickly and effectively
     * show their content for search engines in a modular way.
     *
     * @param SitemapGenerator $sitemap
     * @return SitemapGenerator
     */
    public function sitemap(SitemapGenerator $sitemap)
    {
        /** @var ArticleRepository $repository */
        $repository = app(ArticleRepository::class);

        /** @var Article $article */
        foreach ($repository->whereSitemappable() as $article) {
            $sitemap->store(url($article->route()), $article->updated_at, 'weekly', '1.0');
        }

        return $sitemap;
    }
}
