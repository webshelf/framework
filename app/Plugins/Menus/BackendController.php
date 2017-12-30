<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 13/03/2016
 * Time: 14:55.
 */

namespace App\Plugins\Menus;

use App\Model\Menu;
use App\Model\Page;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use Illuminate\Validation\Rule;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;

/**
 * Class Controller.
 */
class BackendController extends PluginEngine
{
    /**
     * @var MenuRepository
     */
    private $menus;

    /**
     * @var PageRepository
     */
    private $pages;

    /**
     * BackendController constructor.
     *
     * @param MenuRepository $menus
     * @param PageRepository $pages
     */
    public function __construct(MenuRepository $menus, PageRepository $pages)
    {
        $this->menus = $menus;

        $this->pages = $pages;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $group_id
     * @return \Illuminate\Http\Response
     */
    public function index($group_id = 1)
    {
        return $this->make('index')->with('menus', $this->menus->whereTopLevel())->with('list', $this->menus->whereParent($group_id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->make('create')->with('parents', $this->menus->whereTopLevelEditable())->with('pages', $this->pages->listPagesWithoutMenus());
    }

    /**
     * Store a newly created resource in storage.
     *
     * External or Internal Hyperlinks and connections.
     *
     * @param Menu $menu
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Menu $menu)
    {
        $request->validate(['title' => 'min:3|max:255|unique:menus|required']);

        $this->save($request, new Menu);

        return redirect()->route('admin.menus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MenuRepository $repository
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuRepository $repository, $id)
    {
        return $this->make('edit')->with('menu', $repository->whereID($id))->with('parents', $this->menus->whereTopLevelEditable())->with('pages', $this->pages->listPagesWithoutMenus());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param MenuRepository $repository
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuRepository $repository, $id)
    {
        $request->validate(['title' => ['min:3|max:255|required', Rule::unique('menus')->ignore($id)]]);

        $this->save($request, $repository->whereID($id));

        return redirect(route('admin.menus.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param MenuRepository $repository
     * @return bool|null
     * @throws \Exception
     */
    public function destroy($id, MenuRepository $repository)
    {
        $repository->whereID($id)->delete();

        return redirect(route('admin.menus.index'));
    }

    /**
     * Change the order the menu list.
     */
    public function reorder(Request $request, MenuRepository $repository)
    {
        // store the order increment id.
        $increment = 1;

        for ($i = 0; $i < count($request['data']); $i++) {
            $menu = $this->menus->whereID($request['data'][$i]);

            $menu->order = $increment++;

            $menu->save();
        }
    }

    /**
     * Save the data for the menu to the database.
     *
     * @param Request $request
     * @param Menu $menu
     * @return bool
     */
    private function save(Request $request, Menu $menu)
    {
        if (! $request['hyperlinkUrl']) {
            // we expect a page to be connected.
            $request->validate(['page_id' => 'numeric|required']);

            $menu->hyperlink = null;
            $menu->title = $request['title'];
            $menu->page_id = $request['page_id'];
            $menu->parent_id = $request['menu_id'];
            $menu->target = $request['target'];
            $menu->status = true;
            $menu->creator_id = account()->id;
        } else {
            // we expect this to be a hyperlink.
            $request->validate(['hyperlinkUrl' => 'required|max:255|active_url']);

            $menu->page_id = null;
            $menu->title = $request['title'];
            $menu->parent_id = $request['menu_id'];
            $menu->hyperlink = $request['hyperlinkUrl'];
            $menu->target = $request['target'];
            $menu->status = true;
            $menu->creator_id = account()->id;
        }

        return $menu->save();
    }
}
