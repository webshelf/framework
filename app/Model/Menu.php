<?php

namespace App\Model;

use App\Modules\Metrics\ClickableTrait;
use App\Modules\Metrics\Models\Clicks;
use Carbon\Carbon;
use Laravel\Scout\Searchable;
use App\Classes\Interfaces\Linker;
use App\Model\Concerns\Publishers;
use Illuminate\Support\Collection;
use App\Model\Concerns\ActivityFeed;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
 * @property Clicks $clicks
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Menu extends Model implements Linker
{
    /*
     * Laravel Deleting.
     *
     * @ https://laravel.com/docs/5.5/eloquent#soft-deleting
     */
    use SoftDeletes;
    /*
     * Log users activity on this model.
     *
     * @ https://docs.spatie.be/laravel-activitylog/v2/advanced-usage/logging-model-events
     */
    use ActivityFeed;
    /*
     * Log the author and editor of the model
     *
     * @ Webshelf framework 5.1
     */
    use Publishers;
    /*
     * Laravel Searchable Model.
     *
     * @ https://laravel.com/docs/5.3/scout#installation
     */
    use Searchable;
    /*
     * Clickable Model Trait for metric tracking.
     *
     * @ Webshelf Framework 5.3.1
     */
    use ClickableTrait;

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
     * The activity logging strings to be used.
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$eventName} a menu named {$this->title}";
    }

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

    /**
     * Get the first menu with the title name.
     *
     * @param string $title
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public static function firstByTitle(string $title)
    {
        return self::query()->where('title', $title)->first();
    }
}
