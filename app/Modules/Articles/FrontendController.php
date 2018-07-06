<?php

namespace App\Modules\Articles;

use App\Model\Page;
use App\Model\Account;
use App\Model\Article;
use App\Model\Categories;
use App\Jobs\IncrementViews;
use Illuminate\Http\Request;
use App\Classes\SitemapGenerator;
use App\Classes\Interfaces\Sitemap;
use Illuminate\Support\Facades\View;
use App\Classes\Repositories\PageRepository;
use App\Classes\Library\PageLoader\Frontpage;
use App\Classes\Repositories\ArticleRepository;

/**
 * Class UserController.
 */
class FrontendController implements Sitemap
{
    /**
     * @var Page
     */
    private $currentPage;

    /**
     * PageController constructor.
     * @param PageRepository $pages
     * @param View $view
     */
    public function __construct()
    {
        $this->currentPage = Page::whereIdentifier('articles');
    }

    /**
     * List all available articles.
     *
     * @param Article $article
     * @return Frontpage
     */
    public function allArticles(Article $article)
    {
        View::share('articles', $article->published()->latest('created_at')->paginate(7));

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    /**
     * View a single article.
     *
     * @param Categories $category The articles category.
     * @param Article $article The article model to interact with.
     *
     * @return void
     */
    public function viewArticle($category, Article $article)
    {
        IncrementViews::dispatch($article);

        $this->currentPage->heading = $article->title;

        View::share('articles', collect([0 => $article]));

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    /**
     * View all articles in the category.
     *
     * @param ArticleRepository $repository
     * @param string $string
     * @return void
     */
    public function categoryArticles(Categories $category)
    {
        View::share('articles', $category->articles()->where('status', true)->paginate(7));

        $this->currentPage->heading = 'Browse Categories';

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    /**
     * Search all articles and return results.
     *
     * @param ArticleRepository $repository
     * @param Request $request
     *
     * @return void
     */
    public function searchArticles(Request $request)
    {
        View::share('articles', Article::searchModelsByString($request->get('query')));

        $this->currentPage->heading = 'Article Search';

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    /**
     * Get all the articles created by an account.
     *
     * @param ArticleRepository $repository
     * @param int $id
     * @return Frontpage
     */
    public function allCreatorsArticles(ArticleRepository $repository, Account $account)
    {
        $this->currentPage->heading = 'Browse Creators';

        View::share('articles', $account->articles()->paginate(7));

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
