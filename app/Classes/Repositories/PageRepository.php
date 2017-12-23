<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 04/03/2016
 * Time: 23:07.
 */

namespace App\Classes\Repositories;

use App\Model\Page;
use Illuminate\Support\Collection;

/**
 * Class PageRepository.
 *
 * @method Page withTrashed
 */
class PageRepository extends Page
{
    public function whereID(int $integer)
    {
        return $this->where('id', $integer)->first();
    }

    /**
     * @param $plugin_name
     * @return mixed
     */
    public function restoreTrashedPlugin($plugin_name)
    {
        return $this->withTrashed()->where('plugin', $plugin_name)->restore();
    }

    /**
     * @return mixed
     */
    public function makeList() : array
    {
        return $this->pluck('seo_title', 'id')->toArray();
    }

    /**
     * @deprecated
     */
    public function listAllPagesWithoutMenusAndEditable()
    {
        return $this->where('editable', true)->doesntHave('menu')->pluck('seo_title', 'id');
    }

    public function listPagesWithoutMenus()
    {
        return $this->doesntHave('menu')->get();
    }

    public function allPagesWithoutMenusAndEditable() : Collection
    {
        return $this->where('editable', true)->doesntHave('menus')->get();
    }

    /**
     * Get the page based on its name.
     *
     * @return Page|array|\stdClass
     */
    public function whereName($string) : Page
    {
        return $this->where('slug', $string)->first();
    }

    /**
     * Sitemap enabled pages.
     */
    public function whereSitemap() : Collection
    {
        return $this->where('sitemap', true)->where('enabled', true)->get();
    }

    /**
     * Return all pages that are enabled.
     */
    public function enabled() : Collection
    {
        return $this->where('enabled', true)->get();
    }

    public function frontendPageCollection()
    {
        return $this->with(['menu'])->get();
//        return $this->with(['menu' => function ($query) {
//            $query->with('parent');
//        }])->get();
    }
}
