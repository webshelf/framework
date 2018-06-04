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
use App\Plugins\Pages\Model\PageTypes;
use App\Plugins\Pages\Model\PageOptions;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PageRepository.
 *
 * @method Page withTrashed
 */
class PageRepository extends BaseRepository
{
    /**
     * @var Page|Builder|Collection
     */
    protected $model;

    /**
     * PageRepository constructor.
     *
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    /**
     * Return all pages with the bitmask of page standard.
     *
     * @return $collection
     */
    public function allNormalPages()
    {
        $bitmask = PageTypes::TYPE_STANDARD;

        return $this->model->whereRaw('`type` & '.$bitmask.'='.$bitmask)->get();
    }

    /**
     * Return all plugin pages with the bitmask of page standard.
     *
     * @return $collection
     */
    public function allPluginPages()
    {
        $bitmask = PageTypes::TYPE_PLUGIN;

        return $this->model->whereRaw('`type` & '.$bitmask.'='.$bitmask)->get();
    }

    /**
     * Return all error pages with the bitmask of page error.
     *
     * @return $collection
     */
    public function allErrorPages()
    {
        $bitmask = PageTypes::TYPE_ERROR;

        return $this->model->whereRaw('`type` & '.$bitmask.'='.$bitmask)->get();
    }

    /**
     * Return a page where the identifier matches the parameter.
     *
     * @param string $string The identifier string to lookip
     *
     * @return $data
     */
    public function whereIdentifier(string $string)
    {
        return $this->model->where('identifier', $string)->first();
    }

    /**
     * @param $plugin_name
     * @return mixed
     */
    public function restoreTrashedPlugin($plugin_name)
    {
        return $this->model->withTrashed()->where('plugin', $plugin_name)->restore();
    }

    /**
     * @return mixed
     */
    public function makeList() : array
    {
        return $this->model->pluck('seo_title', 'id')->toArray();
    }

    /**
     * @deprecated
     */
    public function listAllPagesWithoutMenusAndEditable()
    {
        return $this->model->where('editable', true)->doesntHave('menu')->pluck('seo_title', 'id');
    }

    public function listPagesWithoutMenus()
    {
        return $this->model->doesntHave('menu')->get();
    }

    public function allPagesWithoutMenusAndEditable() : Collection
    {
        return $this->model->where('editable', true)->doesntHave('menus')->get();
    }

    /**
     * Get the page based on its name.
     *
     * @param $string
     * @return Page|array|\stdClass
     */
    public function whereName($string) : Page
    {
        return $this->model->where('slug', $string)->first();
    }

    /**
     * @param $string
     * @return Page
     */
    public function whereRoute($string) : Page
    {
        return $this->model->where('route', $string)->first();
    }

    /**
     * @param $string
     * @return Page
     */
    public function wherePlugin($string) : Page
    {
        return $this->model->where('plugin', $string)->first();
    }

    /**
     * Sitemap enabled pages.
     */
    public function whereSitemap() : Collection
    {
        $bitmask = PageOptions::OPTION_PUBLIC | PageOptions::OPTION_SITEMAP;

        return $this->model->whereRaw('`option` & '.$bitmask.'='.$bitmask)->get();
    }

    /**
     * Return all pages that are enabled.
     */
    public function enabled() : Collection
    {
        return $this->model->where('enabled', true)->get();
    }

    public function frontendPageCollection()
    {
        return $this->model->with(['menu'])->get();
//        return $this->with(['menu' => function ($query) {
//            $query->with('parent');
//        }])->get();
    }
}
