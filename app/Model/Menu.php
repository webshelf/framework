<?php

namespace App\Model;

use Carbon\Carbon;
use Laravel\Scout\Searchable;
use App\Classes\Interfaces\Linker;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Menus.
 *
 * @property int $id
 * @property string $title
 * @property string $hyperlink
 * @property int $page_id
 * @property string $target
 * @property int $parent_id
 * @property int $order
 * @property bool $status
 * @property bool $lock
 * @property int $creator_id
 * @property int $editor_id
 *
 * @property Link $link
 * @property Menu $parent
 * @property Page $page
 * @property Menu $children
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Menu extends EloquentModel implements Linker
{
    /*
     * Laravel Deleting.
     * @ https://laravel.com/docs/5.5/eloquent#soft-deleting
     */
    use SoftDeletes;
    /*
     * Laravel Searchable Model.
     *
     * @ https://laravel.com/docs/5.3/scout#installation
     */
    use Searchable;

    /**
     * Status if current menu.
     *
     * @var bool
     */
    public $active = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_at', 'created_at', 'deleted_at'];

    /**
     * Return the page that this menu has.
     *
     * @deprecated
     * @return Page|\Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function page()
    {
        return $this->hasOne(Page::class, 'id', 'page_id');
    }

    /**
     * Return the menu that this belongs to.
     *
     * @return Menu|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * The menu can have many submenu children.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * Return the link that this connects to, page or hyperlink.
     *
     * @return MorphOne|Collection|Link
     */
    public function link()
    {
        return $this->morphOne(Link::class, 'from');
    }

    /**
     * Allows the CSS to set a state on the navigation.
     *
     * @return string
     */
    public function classState()
    {
        return $this->active ? 'active' : 'inactive';
    }

    /**
     * Generate the url that this links to.
     *
     * @return mixed
     */
    public function route()
    {
        return url($this->link->url());
    }

    /**
     * The name of the current model object.
     *
     * @return string
     */
    public function name()
    {
        return $this->title;
    }
}
