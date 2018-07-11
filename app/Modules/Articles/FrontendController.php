<?php

namespace App\Modules\Articles;

use App\Model\Page;
use App\Model\Account;
use App\Model\Article;
use App\Model\Categories;
use App\Jobs\IncrementViews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Classes\Repositories\PageRepository;
use App\Classes\Library\PageLoader\Frontpage;

/**
 * Class UserController.
 */
class FrontendController
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
        View::share('articles', $article->latest('created_at')->paginate(7));

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    /**
     * View a single article.
     *
     * @param Categories $category The articles category.
     * @param Article $article The article model to interact with.
     *
     * @return Frontpage
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
     * @param string $string
     * @return Frontpage
     */
    public function categoryArticles(Categories $category)
    {
        View::share('articles', $category->articles()->paginate(7));

        $this->currentPage->heading = 'Browse Categories';

        return Frontpage::build($this->currentPage, 200, 'articles');
    }

    /**
     * Search Articles.
     *
     * @param Request $request
     *
     * @return Frontpage
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
     * @param int $id
     * @return Frontpage
     */
    public function allCreatorsArticles(Account $account)
    {
        $this->currentPage->heading = 'Browse Creators';

        View::share('articles', $account->articles()->paginate(7));

        return Frontpage::build($this->currentPage, 200, 'articles');
    }
}
