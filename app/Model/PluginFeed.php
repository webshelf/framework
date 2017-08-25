<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/09/2016
 * Time: 20:59.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class PluginFeed.
 *
 * Each plugin can have multiple feeds of data that should be loaded with the page.
 *
 * @property Plugin $plugin
 * @property Page   $page
 */
class PluginFeed extends EloquentModel
{
    /**
     * The table in which the data sits at.
     *
     * @var  string
     */
    protected $table = 'plugin_feeds';

    /**
     * Return the size count of data rows to be displayed.
     *
     * @return  mixed
     */
    public function size()
    {
        return $this->getAttribute('size');
    }

    /**
     * @return  PluginContract
     */
    public function plugin()
    {
        return $this->belongsTo(Plugin::class, 'plugin_id', 'id');
    }

    /**
     * @return  PageContract
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
