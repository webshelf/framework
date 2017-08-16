<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 20:30.
 */

namespace App\Plugins\Pages;

use App\Model\Page;
use App\Classes\Popup;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Classes\Breadcrumbs;
use App\Plugins\PluginEngine;
use Illuminate\Contracts\View\View;
use App\Classes\Repositories\PageRepository;
use App\Classes\Interfaces\RouteableInterface;

/**
 * Class Controller.
 */
class AdminController extends PluginEngine implements RouteableInterface
{
    /**
     * @var PageRepository
     */
    private $pages;

    /**
     * AdminController constructor.
     * @param PageRepository $pages
     */
    public function __construct(PageRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * Show a list of all the pages.
     *
     * @return View
     */
    public function index()
    {
        return $this->blade('index')->with('pages', $this->pages->all());
    }

    /**
     * Create the edit page form with page data.
     *
     * @param $name
     * @return View
     */
    public function edit($name)
    {
        return $this->blade('form')->with('page', $this->pages->whereName($name));
    }

    /**
     * Page creation form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return $this->blade('form');
    }

    /**
     * Create a new page.
     *
     * @param Request $request
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function make(Request $request, Page $page)
    {
        $this->validate($request, ['title' => 'required|unique:pages,seo_title,NULL,id,deleted_at,NULL|min:3|max:255']);

        $request['title'] ? $page->setSlug(str_slug($request['title'])) : null;
        $request['enabled'] ? $page->enablePage() : $page->disablePage();

        account()->pages()->save($this->UpdateOrCreate($page, $request));

        popups()->setSession($request->session())->add((new Popup(['message' => 'Your new page was created.']))->success());

        return redirect()->route('pages');
    }

    /**
     * Save a changed page.
     *
     * @param Request $request
     * @param $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, $name)
    {
        $page = $this->pages->whereName($name);

        $this->validate($request, ['title' => 'required|min:3|max:255|unique:pages,seo_title,'.$page->id().',id,deleted_at,NULL']);

        // DO NOT ALLOW THE INDEX PAGE NAME TO CHANGE.
        // DO NOT ALLOW PAGE TO BE UNPUBLISHED
        if ($page->isEditable() == false) {
            $request['enabled'] = 1;
            $request['sitemap'] = 1;
        } else {
            $request['title'] ? $page->setSlug(str_slug($request['title'])) : null;
            $request['enabled'] ? $page->enablePage() : $page->disablePage();
        }

        $this->UpdateOrCreate($page, $request)->save();

        popups()->setSession($request->session())->add((new Popup(['message'=>'Your changes have been saved']))->success());

        // redirect back to the pages plugin menu.
        return redirect()->route('pages');
    }

    /**
     * AJAX CALLS ONLY !!!
     *
     * @param $name
     * @return bool
     */
    public function delete(Request $request, $name)
    {
        $page = $this->pages->whereName($name);

        if ($page->slug() == 'index') {
            return response()->json(['status' => false, 'message' => 'You cannot remove the index page.']);
        }

        if (count($page->menus) >= 1) {
            foreach($page->menus as $menu)
            {
                $menu->trash();
            }
        }

        $page->delete();

        popups()->setSession($request->session())->add((new Popup(['message'=>'Your page has been deleted.']))->success());

        return response()->json(['status' => true, 'notify' => false]);
    }

    /**
     * @param Page $page
     * @param Request $request
     * @return Page
     */
    public function UpdateOrCreate(Page $page, Request $request)
    {
        $request['sitemap'] ? $page->enableSitemap() : $page->disableSitemap();
        $request['title'] ? $page->setSeoTitle(ucfirst($request['title'])) : null;
        $request['description'] ? $page->setSeoDescription(ucfirst($request['description'])) : null;
        $request['keywords'] ? $page->setSeoKeywords(ucfirst($request['keywords'])) : null;
        $request['content'] ? $page->setContent(ucfirst($request['content'])) : null;
        $request['enabled'] ? $page->enablePage() : null;

        return $page;
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
        $router->get('/admin/pages/', ['as' => 'pages',      'uses' => adminPluginController('pages', 'index')]);
        $router->get('/admin/pages/edit/{name}', ['as' => 'EditPage',   'uses' => adminPluginController('pages', 'edit')]);
        $router->post('/admin/pages/save/{name}', ['as' => 'SavePage',   'uses' => adminPluginController('pages', 'save')]);
        $router->get('/admin/pages/create', ['as' => 'CreatePage', 'uses' => adminPluginController('pages', 'create')]);
        $router->post('/admin/pages/make', ['as' => 'MakePage',   'uses' => adminPluginController('pages', 'make')]);
        $router->post('/admin/pages/delete/{name}', ['as' => 'DeletePage', 'uses' => adminPluginController('pages', 'delete')]);

        return $router;
    }
}
