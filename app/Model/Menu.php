<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property Menu $parent
 * @property Page $page
 * @property Menu $children
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Menu extends EloquentModel
{
    /*
     * Laravel Deleting.
     * @ https://laravel.com/docs/5.5/eloquent#soft-deleting
     */
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_at', 'created_at', 'deleted_at'];

    /**
     * Return the page that this menu has.
     *
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
}
