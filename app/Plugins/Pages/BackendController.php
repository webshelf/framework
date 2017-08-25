<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 20:30.
 */

namespace App\Plugins\Pages;

use Illuminate\Support\Facades\DB;
use App\Model\Menu;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use App\Classes\Repositories\PageRepository;

/**
 * Class Controller.
 */
class BackendController extends PluginEngine
{
    /**
     * @var PageRepository
     */
    private $repository;

    /**
     * AdminController constructor.
     * @param PageRepository $repository
     */
    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->make('index')->with('pages', $this->repository->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return $this->make('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $name
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(string $name)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $name
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(string $name)
    {
        return $this->make('edit')->with('page', $this->repository->whereName($name));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $name)
    {
        $page = $this->repository->whereName($name);
        $page->seo_title       = $request['title'];
        $page->slug            = str_slug($request['slug']) ?: str_slug($page->seo_title);
        $page->creator_id      = $request['creator'] ?: account()->id;
        $page->seo_keywords    = $request['keywords'];
        $page->seo_description = $request['description'];
        $page->content         = $request['content'];
        $page->sitemap         = $request['sitemap'] ? true : false;
        $page->enabled         = $request['enabled'] ? true : false;
        $page->saveOrFail();

        return redirect()->route('admin.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $name)
    {
        $page = $this->repository->whereName($name);

        DB::transaction(function () use ($page)
        {
            $page->menus->each(function($menu) {
                /** @var Menu $menu */
                $menu->delete();
            });

            $page->delete();
        });

        $page->delete();


        return redirect()->route('admin.pages.index');
    }
//
//    /**
//     * Show a list of all the pages.
//     *
//     * @return View
//     */
//    public function index()
//    {
//        return $this->make('index')->with('pages', $this->pages->all());
//    }
//
//    /**
//     * Create the edit page form with page data.
//     *
//     * @param $name
//     * @return View
//     */
//    public function edit($name)
//    {
//        return $this->make('form')->with('page', $this->pages->whereName($name));
//    }
//
//    /**
//     * Page creation form.
//     *
//     * @return \Illuminate\Contracts\View\View
//     */
//    public function create()
//    {
//        return $this->make('form');
//    }
//
//    /**
//     * Create a new page.
//     *
//     * @param Request $request
//     * @param Page $page
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function store(Request $request, Page $page)
//    {
//        $this->validate($request, ['title' => 'required|unique:pages,seo_title,NULL,id,deleted_at,NULL|min:3|max:255']);
//
//        $request['title'] ? $page->setSlug(str_slug($request['title'])) : null;
//        $request['enabled'] ? $page->enablePage() : $page->disablePage();
//
//        account()->pages()->save($this->UpdateOrCreate($page, $request));
//
//        return redirect()->route('pages');
//    }
//
//    /**
//     * Save a changed page.
//     *
//     * @param Request $request
//     * @param $name
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function save(Request $request, $name)
//    {
//        $page = $this->pages->whereName($name);
//
//        $this->validate($request, ['title' => 'required|min:3|max:255|unique:pages,seo_title,'.$page->id().',id,deleted_at,NULL']);
//
//        // DO NOT ALLOW THE INDEX PAGE NAME TO CHANGE.
//        // DO NOT ALLOW PAGE TO BE UNPUBLISHED
//        if ($page->isEditable() == false) {
//            $request['enabled'] = 1;
//            $request['sitemap'] = 1;
//        } else {
//            $request['title'] ? $page->setSlug(str_slug($request['title'])) : null;
//            $request['enabled'] ? $page->enablePage() : $page->disablePage();
//        }
//
//        $this->UpdateOrCreate($page, $request)->save();
//
//        popups()->setSession($request->session())->add((new Popup(['message'=>'Your changes have been saved']))->success());
//
//        // redirect back to the pages plugin menu.
//        return redirect()->route('pages');
//    }
//
//    /**
//     * AJAX CALLS ONLY !!!
//     *
//     * @param $name
//     * @return bool
//     */
//    public function destroy($name)
//    {
//        $page = $this->pages->whereName($name);
//
//        if ($page->slug() == 'index') {
//            return response()->json(['status' => false, 'message' => 'You cannot remove the index page.']);
//        }
//
//        if ($page->menus->exists()) {
//            foreach($page->menus as $menu)
//            {
//                $menu->trash();
//            }
//        }
//
//        $page->delete();
//
//        //popups()->setSession($request->session())->add((new Popup(['message'=>'Your page has been deleted.']))->success());
//
//        return response()->json(['status' => true, 'notify' => false]);
//    }
//
//    /**
//     * @param Page $page
//     * @param Request $request
//     * @return Page
//     */
//    public function UpdateOrCreate(Page $page, Request $request)
//    {
//        $request['sitemap'] ? $page->enableSitemap() : $page->disableSitemap();
//        $request['title'] ? $page->setSeoTitle(ucfirst($request['title'])) : null;
//        $request['description'] ? $page->setSeoDescription(ucfirst($request['description'])) : null;
//        $request['keywords'] ? $page->setSeoKeywords(ucfirst($request['keywords'])) : null;
//        $request['content'] ? $page->setContent(ucfirst($request['content'])) : null;
//        $request['enabled'] ? $page->enablePage() : null;
//
//        return $page;
//    }
}
