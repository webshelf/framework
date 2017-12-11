<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 13/03/2016
 * Time: 14:55.
 */

namespace App\Plugins\Menus;

use DB;
use App\Model\Menu;
use App\Model\Page;
use App\Classes\Popup;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use League\Flysystem\Exception;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use Illuminate\Database\Eloquent\Collection;

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
        return $this->make('index')->with('menus', $this->menus->base())->with('list', $this->menus->group($group_id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->make('create')->with('submenus', $this->menus->listAllMenusNotRequired())->with('pages', $this->pages->listAllPagesWithoutMenusAndEditable());
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
        return $this->make('edit')->with('menu', $repository->whereID($id));
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
        return $repository->whereID($id)->delete();
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
        if (!$request['hyperlinkUrl'])
        {
            $menu->link = null;
            $menu->title = $request['title'];
            $menu->page_id = $request['page_id'];
            $menu->menu_id = $request['menu_id'];
            $menu->target  = $request['target'];
            $menu->slug    = str_slug($menu->title);
            $menu->creator_id = account()->id;
        }
        else
        {
            $menu->page_id = null;
            $menu->title = $request['title'];
            $menu->menu_id = $request['menu_id'];
            $menu->link = $request['hyperlinkUrl'];
            $menu->creator_id = account()->id;
        }

        return $menu->save();
    }
}
