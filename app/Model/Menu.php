<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 13/03/2016
 * Time: 15:21.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Interfaces\ActivityInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Menus.
 *
 * @property Account $creator
 * @property Page $page
 * @property mixed submenus
 */
class Menu extends EloquentModel implements ActivityInterface
{
    use SoftDeletes;

    protected $table = 'menus';

    protected $softDeletes = true;

    /**
     * ==========================================================.
     *
     *   GET THE ATTRIBUTES OF THE MODEL
     *
     * ==========================================================
     */
    public function id()
    {
        return $this->getAttribute('id');
    }

    public function title()
    {
        return $this->getAttribute('title');
    }

    public function link()
    {
        return $this->belongsToPage() ? url($this->page->url()) : $this->getAttribute('link');
    }

    /**
     * Return the linked page name.
     *
     * @return mixed
     */
    public function pageTitle()
    {
        return $this->belongsToPage() ? $this->page->seoTitle() : null;
    }

    public function pageName()
    {
        return $this->belongsToPage() ? $this->page->slug() : null;
    }

    public function orderId()
    {
        return $this->getAttribute('order_id');
    }

    public function updatedAt()
    {
        return $this->getAttribute('updated_at');
    }

    public function createdAt()
    {
        return $this->getAttribute('created_at');
    }

    public function isEnabled()
    {
        return $this->getAttribute('enabled') ? true : false;
    }

    /**
     * ==========================================================.
     *
     *   SET THE ATTRIBUTES OF THE MODEL
     *
     * ==========================================================
     */
    public function enableMenu()
    {
        $this->setAttribute('enabled', true);

        return $this;
    }

    public function disableMenu()
    {
        $this->setAttribute('enabled', false);

        return $this;
    }

    public function setEnabled($boolean)
    {
        $this->setAttribute('enabled', $boolean ? true : false);

        return $this;
    }

    public function setLink($string)
    {
        $this->setAttribute('link', $string);

        return $this;
    }

    /**
     * @param $integer
     * @return $this
     */
    public function setOrderID($integer)
    {
        $this->setAttribute('order_id', $integer);

        return $this;
    }

    /**
     * @param $string
     * @return $this
     */
    public function setTitle($string)
    {
        $this->setAttribute('title', ucfirst($string));

        return $this;
    }

    /**
     * Relationship to the submenu table.
     *
     * @return Menu
     */
    public function submenus()
    {
        return $this->hasMany(self::class, 'menu_id', 'id');
    }

    public function setSubmenuID(int $integer)
    {
        $this->setAttribute('menu_id', $integer);
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'menu_id');
    }

    public function slug()
    {
        return $this->getAttribute('slug');
    }

    public function setSlug($string)
    {
        return $this->setAttribute('slug', $string);
    }

    public function target()
    {
        return $this->getAttribute('target');
    }

    public function setTarget($string)
    {
        return $this->setAttribute('target', $string);
    }

    /**
     * Set the page target to open a new window.
     *
     * @return $this
     */
    public function setTargetBlank()
    {
        return $this->setTarget('_blank');
    }

    /**
     * Set the page target to open link in its own window.
     *
     * @return $this
     */
    public function setTargetSelf()
    {
        $this->setTarget('_self');

        return $this;
    }

    /**
     * Relationship to the page.
     *
     * @return Page
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    /**
     * @param $integer
     * @return $this
     */
    public function setPageID($integer)
    {
        $this->setAttribute('page_id', $integer);

        return $this;
    }

    /**
     * Check if menu belongs to a page.
     *
     * @return bool
     */
    public function belongsToPage()
    {
        return $this->pageID() ? true : false;
    }

    public function icon()
    {
        return $this->getAttribute('icon');
    }

    public function setIcon($string)
    {
        return $this->setAttribute('icon', $string);
    }

    public function hasExternalLink(MenuContract $menu)
    {
        return $this->getAttribute('link') ? true : false;
    }

    /**
     * Set the enabled value from
     * 1 - enabled
     * 0 -disabled.
     */
    public function setStatus($boolean)
    {
        return $this->setAttribute('enabled', $boolean);
    }

    public function pageID()
    {
        return $this->getAttribute('page_id');
    }

    /**
     * Make the current menu a requirement of application loading.
     *
     * Boolean for this to be true or false. default is true.
     *
     * @param bool $boolean
     * @return mixed
     */
    public function setRequired($boolean = true)
    {
        if ($boolean == true) {
            $this->setAttribute('required', true);

            return $this;
        }

        $this->setAttribute('required', false);

        return $this;
    }

    /**
     * Return boolean if this is a requirement for loading.
     *
     * @param null $boolean
     * @return mixed
     */
    public function isRequirement($boolean = null)
    {
        if (is_bool($boolean)) {
            return $this->getAttribute('required') == $boolean ? true : false;
        }

        return $this->getAttribute('required') ? true : false;
    }

    /**
     * @param null $boolean
     * @return mixed
     */
    public function isExternal($boolean = null)
    {
        if (is_bool($boolean)) {
            return $this->getAttribute('link') == $boolean ? true : false;
        }

        return $this->getAttribute('link') ? true : false;
    }

    /**
     * Logs will display the activity title that was interacted with.
     *
     * @return  string  -  Title of the activity that should be shown on logs.
     */
    public function feed_title()
    {
        return $this->title();
    }

    /**
     * Logs will create an activity link to allow the user to edit upon click.
     *
     * @return  string  -  Url link that activity will be redirected to.
     */
    public function feed_url()
    {
        return false;
    }

    /**
     * @return Account|mixed
     */
    public function creator() : Account
    {
        return $this->hasOne(Account::class, 'creator_id', 'id');
    }

    /**
     * Logs require a creator to determine who the original account is.
     *
     * @return int
     */
    public function creatorID()
    {
        return $this->getAttribute('creator_id');
    }

    /**
     * @param int $integer
     * @return $this
     */
    public function setCreatorID(int $integer)
    {
        return $this->setAttribute('creator_id', $integer);
    }

    /**
     * Logs any changes to the model with the editor_column.
     *
     * @return int
     */
    public function editorID()
    {
        return $this->getAttribute('editor_id');
    }

    /**
     * Set the editors id to the editor column.
     *
     * @param int $integer
     * @return $this
     */
    public function setEditorID(int $integer)
    {
        return $this->setAttribute('editor_id', $integer);
    }

    /**
     * Get the creator model of the eloquent model.
     *
     * @return Account|mixed
     */
    public function editor()
    {
        return $this->belongsTo(Account::class, 'editor_id', 'id');
    }
}
