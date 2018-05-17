<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 13/03/2016
 * Time: 14:55.
 */

namespace App\Plugins\Menus;

use App\Model\Link;
use App\Model\Menu;
use App\Model\Activity;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use Illuminate\Validation\Rule;
use App\Classes\Repositories\LinkRepository;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use PhpParser\Error;

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
     * @var LinkRepository
     */
    private $links;

    /**
     * BackendController constructor.
     *
     * @param MenuRepository $menus
     * @param PageRepository $pages
     */
    public function __construct(MenuRepository $menus, PageRepository $pages, LinkRepository $links)
    {
        $this->menus = $menus;

        $this->pages = $pages;

        $this->links = $links;
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
        return $this->make('create')->with('parents', $this->menus->whereTopLevelEditable())->with('linkableObjects', $this->links->allLinkableObjects());
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
        $request->validate(['title' => 'min:3|max:255|unique:menus,title,NULL,id,deleted_at,NULL|required']);

        $this->save($request, $menu);

        account()->record(Activity::$created, $menu);

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
    public function edit($id)
    {
        return $this->make('edit')->with('menu', $this->menus->whereID($id))->with('parents', $this->menus->whereTopLevelEditable())->with('linkableObjects', $this->links->allLinkableObjects());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param MenuRepository $repository
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(['title' => ['min:3|max:255|required', Rule::unique('menus')->ignore($id)]]);

        $menu = $this->menus->whereID($id);

        $this->save($request, $menu);

        account()->record(Activity::$updated, $menu);

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
    public function destroy($id)
    {
        $menu = $this->menus->whereID($id);

        if ($menu->children) {
            foreach ($menu->children as $submenu) {
                $submenu->link->delete();
            }
        }

        $menu->link->delete();

        account()->record(Activity::$deleted, $menu);

        $menu->delete();

        return redirect(route('admin.menus.index'));
    }

    /**
     * Change the order the menu list.
     */
    public function reorder(Request $request)
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
        $this->validate($request, ['title => required|min:3|max:255']);

        DB::transaction(function () use ($request, $menu){
            if ($request['linkable_object'])
                $menu = $this->internalMenu($request, $menu);
            else if ($request['hyperlinkUrl'])
                $menu = $this->externalMenu($request, $menu);
            else
                $menu = $this->recursiveMenu($request, $menu);        
        }, 5);
    
    }

    /**
     * External menus use the menu resource linked to an external url.
     *
     * @param Menu $menu
     * @return bool
     */
    private function externalMenu(Request $request, Menu $menu)
    {
        if ($request['hyperlinkUrl'] != "#") {
            $this->validate($request, ['hyperlinkUrl' => 'sometimes|max:255|string|active_url'], [
                'hyperlinkUrl.active_url' => 'Hyperlink url is not a valid address, please use http:// or https://'
            ]);
        }

        $menu->page_id = null;
        $menu->title = $request['title'];
        $menu->parent_id = $request['menu_id'];
        $menu->hyperlink = $request['hyperlinkUrl'];
        $menu->target = $request['target'];
        $menu->status = true;
        $menu->creator_id = account()->id;
        $menu->save();

        // save the new external link to the model.
        app(Link::Class)->external($menu, $request['hyperlinkUrl']);

        return true;
    }

    /**
     * Internal Menus are linked to a linable object.
     *
     * @param Menu $menu
     * @return bool
     */
    private function internalMenu(Request $request, Menu $menu)
    {
        $model = json_decode($request['linkable_object']);
        $menu->title = $request['title'];
        $menu->page_id = $request['page_id'];
        $menu->parent_id = $request['menu_id'];
        $menu->target = $request['target'];
        $menu->status = true;
        $menu->creator_id = account()->id;
        $menu->save();

        // save the model resource link to the other resource.
        if ($menu->link)
            $menu->link->model($menu, getMorphedModel($model->class, $model->key));
        else 
            app(Link::class)->model($menu, getMorphedModel($model->class, $model->key));

        return true;
    }

    /**
     * Recursive Menus are resources without any linkable content, in such cases, the menu will link to itself.
     *
     * @param Request $request
     * @param Menu $menu
     * @return boolean
     */
    private function recursiveMenu(Request $request, Menu $menu)
    {
        $menu->title = $request['title'];
        $menu->target = $request['target'];
        $menu->status = true;
        $menu->creator_id = account()->id;
        $menu->save();

        app(Link::Class)->external($menu, '#');

        return true;
    }
}
