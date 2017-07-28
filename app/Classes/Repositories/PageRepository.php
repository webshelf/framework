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
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PageRepository.
 */
class PageRepository
{
    /**
     * The model for eloquent access.
     *
     * @var Builder
     */
    private $model;

    /**
     * AccountRepository constructor.
     *
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function all() : Collection
    {
        return $this->model->get();
    }

    public function whereID(int $integer)
    {
        return $this->model->where('id', $integer)->first();
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

    public function listAllPagesWithoutMenusAndEditable()
    {
        return $this->model->whereNotNull('editable')->doesntHave('menus')->pluck('seo_title', 'id');
    }

    public function allPagesWithoutMenusAndEditable() : Collection
    {
        return $this->model->whereNotNull('editable')->doesntHave('menus')->get();
    }

    /**
     * Get the page based on its name.
     *
     * @return Page|array|\stdClass
     */
    public function whereName($string) : Page
    {
        return $this->model->where('slug', $string)->first();
    }

    /**
     * Sitemap enabled pages.
     */
    public function whereSitemap() : Collection
    {
        return $this->model->where('sitemap', true)->where('enabled', true)->get();
    }

    /**
     * Return all pages that are enabled.
     */
    public function enabled() : Collection
    {
        return $this->model->where('enabled', true)->get();
    }

    public function allWithMenuAndParent()
    {
        return $this->model->with(['menu' => function ($query) {
            $query->with('parent');
        }])->get();
    }
}
