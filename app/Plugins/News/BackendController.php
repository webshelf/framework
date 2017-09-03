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
use App\Plugins\PluginEngine;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use App\Classes\Repositories\ArticleRepository;
use App\Classes\Interfaces\InstallableInterface;
use App\Plugins\Menus\BackendController as MenuController;

/**
 * Class Controller.
 */
class BackendController extends PluginEngine implements InstallableInterface
{
    private $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    /**
     * A list of all the news articles created, in a table.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->make('index')->with('articles', $this->articles->all());
    }

    /**
     * The form for creating a new news post.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return $this->make('create');
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
        return $this->make('edit')->with('article', $this->articles->whereSlug($slug));
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

                /* @var Plugin $plugin */
                $plugin->setInstalled(true);
                $plugin->save();

                /* @var Page $page */
                $page->slug = 'news';
                $page->seo_title = 'News';
                $page->plugin = 'News';
                $page->editable = false;
                $page->enabled = true;
                $page->sitemap = true;
                $page->creator_id = account()->id;
                $page->save();

                /* @var Menu $menu */
                $menu->slug = (str_slug(strtolower($plugin->name())));
                $menu->title = ('News');
                $menu->target = ('_self');
                $menu->required = (true);
                $menu->creator_id = (account()->id);
                $menu->page_id = ($page->id);
                $menu->enabled = (true);
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
