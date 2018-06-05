<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/05/2016
 * Time: 22:27.
 */

namespace App\Plugins\Articles;

use App\Model\Page;
use App\Plugins\Articles\Model\Article;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use App\Classes\SitemapGenerator;
use App\Classes\Interfaces\Sitemap;
use Illuminate\View\Factory as View;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use App\Classes\Library\PageLoader\Frontpage;
use App\Classes\Repositories\ArticleRepository;
use App\Jobs\IncrementViews;
use App\Classes\Repositories\ArticleCategoryRepository;

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

        $this->currentPage = $pages->whereIdentifier('articles');
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

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    /**
     * Load a single article from the news plugin.
     *
     * @param ArticleRepository $repository
     * @param string $category The category type of the url.
     * @param string $slug The slug of the url article.
     * 
     * @return void
     */
    public function article(ArticleRepository $repository, string $category, string $slug)
    {
        /** @var Article $article */
        $article = $repository->collectArticle($slug);

        IncrementViews::dispatch($article);

        $this->currentPage->heading = $article->title;

        $this->view->share('articles', collect([0 => $article]));

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    /**
     * Search for an array of articles based on title and content.
     *
     * @param ArticleRepository $repository
     * @param Request $request
     * 
     * @return void
     */
    public function search(ArticleRepository $repository, Request $request)
    {
        $this->view->share('articles', $repository->searchThenPaginate($request->get('search')));

        $this->currentPage->heading = 'Article Search';

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    public function category(ArticleRepository $repository, string $string)
    {
        $this->view->share('articles', $repository->whereCategoryTitle($string));

        $this->currentPage->heading = 'Browse Categories';

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    public function creator(ArticleRepository $repository, int $id)
    {
        $this->view->share('articles', $repository->whereCreatorId($id));

        $this->currentPage->heading = 'Browse Creators';

        return Frontpage::build($this->currentPage, 200, 'articles');
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
