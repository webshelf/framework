<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 20:30.
 */

namespace App\Plugins\Pages;

use App\Model\Link;
use App\Model\Page;
use App\Model\Activity;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use Illuminate\Validation\Rule;
use App\Plugins\Pages\Model\PageTypes;
use App\Plugins\Pages\Model\PageOptions;
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
        return $this->make('index')->with('pages', $this->repository->allNormalPages());
    }

    public function indexPlugin()
    {
        return $this->make('index')->with('pages', $this->repository->allPluginPages());
    }

    /**
     * List all the error pages for user editing such as 404, etc..
     *
     * @return Response $response The response giving from the method.
     */
    public function indexError()
    {
        return $this->make('index')->with('pages', $this->repository->allErrorPages());
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

        $this->save($request, $page);

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
     * @param PageRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $name, PageRepository $repository)
    {
        $page = $repository->whereName($name);

        $this->validate($request, ['title'=>'required|min:3|max:255', Rule::unique('pages')->ignore($page->id)]);

        $this->save($request, $page);

        return redirect()->route('admin.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @param PageRepository $repository
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($slug, PageRepository $repository)
    {
        $page = $repository->whereName($slug);

        // Disconnect the linked page from the parent link.
        if ($page->linked) {
            foreach ($page->linked as $link) {
                $link->disconnect();
            }
        }

        // Remove the page and log the disconnection.
        if ($page->editable && ! $page->plugin) {
            $repository->whereName($slug)->delete();
        }

        return redirect()->route('admin.pages.index');
    }

    /**
     * Resource data for saving.
     *
     * @param Request $request
     * @param Page $page
     */
    private function save(Request $request, Page $page)
    {
        // Standard for all pages.
        $page->heading = $request['title'];
        $page->prefix = strtolower($request['prefix']);
        $page->creator_id = $request['creator'] ?: account()->id;
        $page->seo_keywords = $request['keywords'];
        $page->seo_description = $request['description'];
        $page->content = $request['content'];

        // if the page alreayd exists setup a basic option and type.
        if (! $page->exists) {
            $page->type = PageTypes::TYPE_STANDARD;
            $page->option = PageOptions::OPTION_PUBLIC | PageOptions::OPTION_SITEMAP;
        }

        // We do not allow framework slugs to change.
        if (! $page->isType('framework')) {
            $page->slug = str_slug($page->heading);
        }

        // save the page.
        $page->save();
    }
}
