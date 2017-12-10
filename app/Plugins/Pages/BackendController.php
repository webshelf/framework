<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 20:30.
 */

namespace App\Plugins\Pages;

use App\Model\Menu;
use App\Model\Page;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use Illuminate\Support\Facades\DB;
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
     * @param  \Illuminate\Http\Request $request
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Page $page)
    {
        $this->validate($request, ['title' => 'required|unique:pages,seo_title,NULL,id,deleted_at,NULL|min:3|max:255']);

        $page->seo_title = $request['title'];
        $page->slug = str_slug($request['slug']) ?: str_slug($page->seo_title);
        $page->creator_id = $request['creator'] ?: account()->id;
        $page->seo_keywords = $request['keywords'];
        $page->seo_description = $request['description'];
        $page->content = $request['content'];
        $page->sitemap = true; // $request['sitemap'] ? true : false;
        $page->enabled = true; // $request['enabled'] ? true : false;
        $page->save();

        return redirect()->route('admin.pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param string $name
     * @return bool
     */
    public function show(string $name)
    {
        return false;
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

        $this->validate($request, ['title'=>'required|min:3|max:255|unique:pages,seo_title,'.$page->id.',id,deleted_at,NULL']);

        $page->seo_title = $request['title'];
        $page->slug = str_slug($request['slug']) ?: str_slug($page->seo_title);
        $page->creator_id = $request['creator'] ?: account()->id;
        $page->seo_keywords = $request['keywords'];
        $page->seo_description = $request['description'];
        $page->content = $request['content'];
        $page->sitemap = true; //$request['sitemap'] ? true : false;
        $page->enabled = true; //$request['enabled'] ? true : false;
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

        DB::transaction(function () use ($page) {
            $page->menus->each(function ($menu) {
                /* @var Menu $menu */
                $menu->delete();
            });

            $page->delete();
        });

        $page->delete();

        return redirect()->route('admin.pages.index');
    }
}
