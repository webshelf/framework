<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 19/01/2018
 * Time: 12:46
 */

namespace App\Classes\Repositories;

use App\Classes\Interfaces\Linkable;
use App\Model\Link;
use Illuminate\Support\Collection;

/**
 * Class LinkRepository
 *
 * @package App\Classes\Repositories
 */
class LinkRepository extends BaseRepository
{
    /**
     * @var Link
     */
    protected $model;

    /**
     * PageRepository constructor.
     *
     * @param Link $model
     */
    public function __construct(Link $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function allLinkableObjects() : Collection
    {
        $pages = app(PageRepository::class)->all();

        return collect($pages);
    }
}