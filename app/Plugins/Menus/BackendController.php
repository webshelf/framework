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
     * AdminController constructor.
     * @param MenuRepository $menus
     * @param PageRepository $pages
     */
    public function __construct(MenuRepository $menus, PageRepository $pages)
    {
        $this->menus = $menus;

        $this->pages = $pages;
    }

    /**
     * Show all the menus in one place.
     */
    public function index()
    {
        return $this->make('index')->with('menus', $this->menus->allByPriorityOrder())->with('pages', $this->pages->allPagesWithoutMenusAndEditable())->with('submenu_group', $this->menus->allSubmenusByPriorityOrderAndGrouped());
    }

    /**
     * Create a menu form.
     */
    public function create()
    {
        return $this->make('create')->with('submenus', $this->menus->listAllMenusNotRequired())->with('pages', $this->pages->listAllPagesWithoutMenusAndEditable());
    }

    /**
     * Delete a menu with ajax.
     *
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function ajax_delete(Request $request, $id)
    {
        try {
            /** @var Menu $menu */
            $menu = $this->menus->whereID($id);

            if ($menu->isRequirement(true)) {
                return response()->json(['success' => false, 'message' => 'You cannot remove application bound menus']);
            }

            $menu_id = $menu->id();

            $menu->submenus()->delete();

            $menu->delete();

            if ($menu_id) {
                $this->reorderRowsFromCollection($this->menus->allMenus());
            } else {
                $this->reorderRowsFromCollection($this->menus->submenusWhereID($menu_id));
            }

            popups()->setSession($request->session())->add((new Popup(['message' => 'Menu and its entities were removed successfully.']))->success());

            return response()->json(['success' => true, 'notify' => false]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'notify' => true]);
        }
    }

    /**
     * Update the menu values with ajax.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax_update(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'value' => 'required',
            ],
            [
                'value.required' => 'A valid value is required.',
            ]);

        if ($validator->fails()) {
            return response()->json(['error' => ['message' => $validator->errors()->first()]]);
        }

        // VALIDATION FOR TITLES
        if ($request['name'] == 'title') {
            $request['title'] = str_slug($request['value']);

            $validator = \Validator::make($request->all(),
                [
                    'title' => 'unique:menus,slug,NULL,id,deleted_at,NULL|required|min:3|max:255',
                ],
                [
                    'title.unique' => 'A menu with this name already exists!',
                ]);

            if ($validator->fails()) {
                return response()->json(['error' => ['message' => $validator->errors()->first()]]);
            }
        }

        // VALIDATION FOR LINKS
        if ($request['name'] == 'link') {
            $request['link'] = $request['value'];
            {
                $hashed = str_contains($request['value'], '#');

                if ($hashed == false) {
                    $validator = \Validator::make($request->all(),
                    [
                        'link' => 'active_url',
                    ]);

                    if ($validator->fails()) {
                        return response()->json(['error' => ['message' => $validator->errors()->first()]]);
                    }
                }
            }
        }

        try {
            $method = 'set'.ucwords($request['name']);

            /** @var Menu $menu */
            $menu = $this->menus->whereID($request['pk']);

            /*
             * DO NOT CHANGE THE SLUG OF REQUIRED ITEMS, SINCE
             * THE APPLICATION USES THE SLUG TO RETRIEVE THE ITEM.
             */
            if ($menu->isRequirement(false) && $request['name'] == 'title') {
                $menu->setSlug($request['title']);
            }

            $menu->$method($request['value'])->save();
        } catch (Exception $e) {
            return response()->json(['error' => ['message' => 'Some strange error has occurred.']]);
        }
    }

    /**
     * Run this to re-order all columns of their counterpart menus
     * if a row is deleted or it becaomes somewhat unsynced.
     *
     * @param Collection $collection
     * @return bool
     */
    public function reorderRowsFromCollection(Collection $collection = null)
    {
        $menus = $collection->sortBy('order_id');

        $order = 1;

        /** @var Menu $menu */
        foreach ($menus as $menu) {
            $menu->setOrderID($order)->save();

            $order += 1;
        }

        return true;
    }

    /**
     * Reorder the menus location to the table using datatables API.
     * This uses a transaction protocol so that no interactions can be made to it
     * while this is in progress, which in turn makes it more consistent with what it does.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax_order(Request $request)
    {
        $json = $request->json()->all();

        DB::beginTransaction();

        try {
            foreach ($json as $array) {
                $slug = $array['slug'];
                $new_value = $array['n'];

                ($this->menus->whereName($slug))->setOrderID($new_value)->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success'=>false, 'message'=>'Changes could not be saved.']);
        }

        return response()->json(['success'=>true, 'message'=>'Your changes to the row orders have been saved.']);
    }

    /**
     *  Process a form into a mode.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Menu $menu)
    {
        $request['slug'] = str_slug($request['title']);

        // we must validate that a title exists.
        $this->validate($request, ['slug' => 'required|unique:menus,slug,NULL,id,deleted_at,NULL|min:3|max:255']);

        /*
         * Generic page creation with only a single attached internal page.
         * This does not contain, submenus, or external links.
         */
        if ($this->isInternalPageCreation($request)) {
            /** @var Page $page */
            $page = $this->pages->whereID($request['page_id']);
            $menu->setTitle($request['title']);
            $menu->setSlug(str_slug($request['title']));
            $menu->setTarget($request['target']);
            $menu->setEnabled($request['enabled'] ?? false);
            $menu->setCreatorID(account()->id);
            $this->attachSubmenuIfExists($request, $menu);
            $page->menus()->save($menu);
            if ($request['submenu_id']) {
                $this->reorderRowsFromCollection($this->menus->submenusWhereID($request['submenu_id']));
            } else {
                $this->reorderRowsFromCollection($this->menus->all());
            }

            return redirect()->route('menus');
        } elseif ($this->isExternalPageCreation($request)) {
            $this->validate($request, ['external_link'=>'url']);
            $menu->setTitle($request['title']);
            $menu->setSlug(str_slug($request['title']));
            $menu->setTarget($request['target']);
            $menu->setEnabled($request['enabled']);
            $menu->setCreatorID(account()->id);
            $menu->setLink($request['external_link']);
            $this->attachSubmenuIfExists($request, $menu);
            $menu->save();
            if ($request['submenu_id']) {
                $this->reorderRowsFromCollection($this->menus->submenusWhereID($request['submenu_id']));
            } else {
                $this->reorderRowsFromCollection($this->menus->all());
            }

            return redirect()->route('menus');
        }

        $this->validate($request, ['page_id' => 'required', 'external_link' => 'required'], ['required'=>'Please attach either a page or external link to this menu']);

        return redirect()->route('menus');
    }

    /**
     * Check if a submenu id exists for the new menu.
     * If true, save it to the menus creation.
     *
     * @param Request $request
     * @param Menu $menu
     * @return Menu
     */
    private function attachSubmenuIfExists(Request $request, Menu $menu)
    {
        if ($request['submenu_id']) {
            $submenu = $this->menus->whereID($request['submenu_id']);

            $menu->setSubmenuID($submenu->id());
        }

        return $menu;
    }

    /**
     * Check that the form being process is a internal page creation only.
     *
     * @param Request $request
     * @return bool
     */
    private function isExternalPageCreation(Request $request)
    {
        return $request['external_link'] && ! $request['page_id'];
    }

    /**
     * Check that the form being process is a internal page creation only.
     *
     * @param Request $request
     * @return bool
     */
    private function isInternalPageCreation(Request $request)
    {
        return $request['page_id'] && ! $request['external_link'];
    }

    /**
     * Attach a page to the menu as a sub.
     *
     * Messey on one line but saves some space.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attach(Request $request)
    {
        /** @var Page $page */
        $page = $this->pages->whereID($request['page_id']);

        /** @var Menu $menu */
        $menu = $this->menus->whereID($request['menu_id']);

        $menu->submenus()->save((new Menu)->setTitle(ucfirst($page->seo_title))->setLink(url(str_slug(ucfirst($page->seo_title))))->setEnabled(true));

        return redirect()->route('menus');
    }

    /**
     * Create a menu using a page as a base information.
     *
     * @param Request $request
     * @param Menu $menu
     * @return mixed
     */
    public function page(Request $request, Menu $menu)
    {
        /** @var Page $page */
        $page = $this->pages->whereID($request['page_id']);

        $menu = new Menu;
        $menu->setLink(url($page->slug));
        $menu->setTitle($page->seo_title);
        $menu->setEnabled(true);
        $menu->save();

        return redirect()->route('menus');
    }
}
