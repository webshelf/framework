<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Menus.
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $icon
 * @property string $link
 * @property int $page_id
 * @property string $target
 * @property int $menu_id
 * @property int $order_id
 * @property bool $enabled
 * @property bool $required
 * @property int $creator_id
 * @property int $editor_id
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Page page
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
     * Generate a link that the menu will visit when clicked.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function link()
    {
        return $this->page ? url($this->page->slug) : $this->link;
    }

    /**
     * Relationship to the submenu table.
     *
     * @return Menu|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submenus()
    {
        return $this->hasMany(self::class, 'menu_id', 'page_id');
    }

    /**
     * A Menu can have a menu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'menu_id');
    }

    /**
     * Menu belongs to a single Page.
     *
     * @return Page|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    /**
     * Get the creators account name.
     *
     * @return Account|mixed
     */
    public function creator() : Account
    {
        return $this->hasOne(Account::class, 'creator_id', 'id');
    }

    /**
     * Get the creator model of the eloquent model.
     *
     * @return Account|mixed
     */
    public function modifier()
    {
        return $this->belongsTo(Account::class, 'editor_id', 'id');
    }
}
