<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/09/2016
 * Time: 21:03.
 */

namespace App\Classes\Repositories;

use App\Model\Plugin;
use App\Model\PluginFeed;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PluginFeedRepository.
 */
class PluginFeedRepository extends PluginFeed
{

    /**
     * Broadcasts are plugins to be displayed to all front
     * end pages of the front end site.
     *
     * @return mixed
     */
    public function broadcasts()
    {
        return $this->whereNull('page_id')->get();
    }

    /**
     * @param $integer
     * @return PluginFeed|Collection
     */
    public function wherePageID($integer)
    {
        return $this->where('page_id', $integer)->get();
    }

    /**
     * @param $integer
     * @return PluginFeed|Collection
     */
    public function loadFeedsForPageID($integer)
    {
        return $this->where('page_id', $integer)->orWhere('page_id', null)->get();
    }
}
