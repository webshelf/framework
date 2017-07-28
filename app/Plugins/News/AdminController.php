<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/04/2016
 * Time: 02:26.
 */

namespace App\Plugins\News;

use Carbon\Carbon;
use App\Model\Menu;
use App\Model\Page;
use App\Model\Plugin;
use App\Model\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Classes\Breadcrumbs;
use App\Plugins\PluginEngine;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use App\Classes\Interfaces\RouteableInterface;
use App\Classes\Repositories\ArticleRepository;
use App\Classes\Interfaces\InstallableInterface;
use App\Plugins\Menus\AdminController as MenuController;

/**
 * Class Controller.
 */
class AdminController extends PluginEngine implements RouteableInterface, InstallableInterface
{
    private $articles;

    public function __construct(Breadcrumbs $breadcrumbs, ArticleRepository $articles)
    {
        parent::__construct($breadcrumbs);

        $this->articles = $articles;
    }

    /**
     * A list of all the news articles created, in a table.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->blade('index')->with('articles', $this->articles->all());
    }

    /**
     * The form for creating a new news post.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return $this->blade('create');
    }

    /**
     * Store a new article into the database.
     *
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Article $article)
    {
        $article->enableArticle();

        // STANDARD ARTICLE COLUMNS THAT SHOULD BE FILLED.

        $article->setTitle($request['title']);
        $article->setSlug(str_slug($request['title']));
        $article->setContent($request['content']);

        // SET SEO DEFINED ATTRIBUTES IF THEY HAVE BEEN DEFINED O.O

        $request['seo_title'] ? $article->setSeoTitle($request['seo_title']) : null;
        $request['seo_keywords'] ? $article->setSeoKeywords($request['seo_keywords']) : null;
        $request['seo_description'] ? $article->setSeoDescription($request['seo_description']) : null;

        // IF NO DATE DEFINED, SET IT BY DEFAULT TO CURRENT TIME AND DATE.

        $request['defined_date'] ? $article->setEventDate(Carbon::createFromFormat('Y-m-d H:i', $request['defined_date'])) : $article->setEventDate(Carbon::now());

        // THE ARTICLE CREATOR SHOULD BE THE PERSON MAKING THE ARTICLE.. RIGHT?
        // MAYBE AN OPTION THAT ALLOWS YOU TO POST FOR SOMEONE ELSE IN THE FUTURE.

        account()->articles()->save($article);

        return redirect()->intended(route('news'));
    }

    /**
     * REeturn the form for editing an article.
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($slug)
    {
        return $this->blade('edit')->with('article', $this->articles->whereSlug($slug));
    }

    /**
     * Update an edited article post.
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $slug)
    {
        $article = $this->articles->whereSlug($slug);

        $article->setTitle($request['title']);
        $article->setSlug(str_slug($request['title']));
        $article->setContent($request['content']);

        // SET SEO DEFINED ATTRIBUTES IF THEY HAVE BEEN DEFINED O.O

        $request['seo_title'] ? $article->setSeoTitle($request['seo_title']) : null;
        $request['seo_keywords'] ? $article->setSeoKeywords($request['seo_keywords']) : null;
        $request['seo_description'] ? $article->setSeoDescription($request['seo_description']) : null;

        // IF NO DATE DEFINED, SET IT BY DEFAULT TO CURRENT TIME AND DATE.

        $request['defined_date'] ? $article->setEventDate(Carbon::createFromFormat('Y-m-d H:i', $request['defined_date'])) : $article->setEventDate(Carbon::now());

        $article->modifier()->associate(account())->save();

        return redirect()->intended(route('news'));
    }

    /**
     * Routes required for the plugin to operate correctly.
     * These define all available urls that require Auth, or not.
     * These are loaded on application boot time and may be cached.
     *
     * @param Router $router
     * @return mixed
     */
    public function routes(Router $router)
    {
        $router->get('/admin/news/', ['as' =>'news',       'uses' => adminPluginController('news', 'index')]);
        $router->get('/admin/news/create', ['as' =>'CreateNews', 'uses' => adminPluginController('news', 'create')]);
        $router->post('/admin/news/store', ['as' =>'StoreNews',  'uses' => adminPluginController('news', 'store')]);
        $router->get('/edit/news/{slug}', ['as' =>'EditNews',   'uses' => adminPluginController('news', 'edit')]);
        $router->post('/edit/news/{slug}', ['as' =>'UpdateNews', 'uses' => adminPluginController('news', 'update')]);
    }

    /**
     * Steps required for the application install.
     * Usually defined for logging & new sql entries.
     *
     * @return mixed
     */
    public function install(Plugin $plugin)
    {
        if ($plugin->isInstalled() == false) {
            $page = new Page;
            $menu = new Menu;

            \DB::transaction(function () use ($page, $menu, $plugin) {
                $account_id = account()->id();

                /* @var Plugin $plugin */
                $plugin->setInstalled(true);
                $plugin->save();

                /* @var Page $page */
                $page->setSlug('news');
                $page->setSeoTitle('News');
                $page->setPlugin('news');
                $page->setEditable(false);
                $page->setEnabled(true);
                $page->setSitemap(true);
                $page->setCreatorID($account_id);
                $page->save();

                /* @var Menu $menu */
                $menu->setSlug(str_slug(strtolower($plugin->name())));
                $menu->setTitle('News');
                $menu->setTarget('_self');
                $menu->setRequired(true);
                $menu->setCreatorID($account_id);
                $menu->setPageID($page->id());
                $menu->setStatus(true);
                $menu->save();

                (app(MenuController::class))->reorderRowsFromCollection(app(MenuRepository::class)->allMenus());
            });
        } else {
            app(PageRepository::class)->restoreTrashedPlugin($plugin->name());
            app(MenuRepository::class)->restoreTrashedPlugin($plugin->name());
        }

        return true;
    }

    /**
     * Steps required for the application uninstall.
     * Usually defined for logging & new sql entries.
     *
     * @param Plugin $plugin
     *
     * @return mixed|void
     */
    public function uninstall(Plugin $plugin)
    {
        app(PageRepository::class)->whereName($plugin->name())->delete();
        app(MenuRepository::class)->whereName($plugin->name())->delete();
    }
}
