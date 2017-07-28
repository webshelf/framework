<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Interfaces\ActivityInterface;

/**
 * Class Pages.
 *
 * @property Account getPublisher
 * @property Redirect redirect
 */
class Page extends Engine implements ActivityInterface
{
    use SoftDeletes;

    protected $table = 'pages';

    protected $softDeletes = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * ==========================================================.
     *
     *   GET THE ATTRIBUTES OF THE MODEL
     *
     * ==========================================================
     */
    public function construct($title = '', $description = '', $keywords = '', $content = '')
    {
        $this->setSeoTitle($title);
        $this->setSeoDescription($description);
        $this->setSeoKeywords($keywords);
        $this->setContent($content);

        $this->setSlug(str_slug($title));

        return $this;
    }

    public function id()
    {
        return $this->getAttribute('id');
    }

    public function slug()
    {
        return $this->getAttribute('slug');
    }

    public function content()
    {
        return $this->getAttribute('content');
    }

    public function banner()
    {
        return $this->getAttribute('banner');
    }

    public function seoTitle()
    {
        return ucfirst($this->getAttribute('seo_title'));
    }

    public function isSitemap()
    {
        return $this->getAttribute('sitemap');
    }

    public function seoDescription()
    {
        return $this->getAttribute('seo_description');
    }

    public function isEnabled()
    {
        return $this->getAttribute('enabled') ? true : false;
    }

    public function seoKeywords()
    {
        return $this->getAttribute('seo_keywords');
    }

    public function getDeletedAt()
    {
        return $this->getAttribute('deleted_at');
    }

    public function updatedAt()
    {
        return $this->getAttribute('updated_at');
    }

    public function getCreatedAt()
    {
        return $this->getAttribute('created_at');
    }

    /**
     * ==========================================================.
     *
     *   SET THE ATTRIBUTES OF THE MODEL
     *
     * ==========================================================
     */
    public function enableSitemap()
    {
        $this->setAttribute('sitemap', 1);

        return $this;
    }

    public function disableSitemap()
    {
        $this->setAttribute('sitemap', 0);

        return $this;
    }

    public function enablePage()
    {
        $this->setAttribute('enabled', 1);

        return $this;
    }

    public function setEnabled(bool $boolean)
    {
        $this->setAttribute('enabled', $boolean);

        return $this;
    }

    public function disablePage()
    {
        $this->setAttribute('enabled', 0);

        return $this;
    }

    public function setSlug($string)
    {
        $this->setAttribute('slug', $string);

        return $this;
    }

    public function setBanner($text)
    {
        $this->setAttribute('banner', $text);

        return $this;
    }

    public function setSeoTitle($string)
    {
        $this->setAttribute('seo_title', $string);

        return $this;
    }

    public function setSeoDescription($text)
    {
        $this->setAttribute('seo_description', $text);

        return $this;
    }

    public function setSeoKeywords($tags)
    {
        $this->setAttribute('seo_keywords', $tags);

        return $this;
    }

    public function setContent($longText)
    {
        $this->setAttribute('content', nl2br($longText));

        return $this;
    }

    public function isDisabled()
    {
        return ! $this->getAttribute('enabled');
    }

    /**
     * @deprecated
     */
    public function menus()
    {
        return $this->hasMany(Menu::class, 'page_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function menu()
    {
        return $this->hasOne(Menu::class, 'page_id', 'id');
    }

    public function isPlugin()
    {
        return $this->getAttribute('plugin') ? true : false;
    }

    /**
     * @param $string
     * @return $this
     */
    public function setPlugin($string)
    {
        $this->setAttribute('plugin', $string);

        return $this;
    }

    /**
     * Check if view exists first, otherwise check database.
     *
     * @return bool
     */
    public function isEditable()
    {
        if (view()->exists('site.plugin::'.$this->slug())) {
            return false;
        }

        return $this->getAttribute('editable') ? true : false;
    }

    public function makeUneditable()
    {
        $this->setAttribute('editable', null);

        return $this;
    }

    public function makeEditable()
    {
        $this->setAttribute('editable', true);

        return $this;
    }

    public function setEditable(bool $boolean)
    {
        $this->setAttribute('editable', $boolean ?: null);

        return $this;
    }

    /**
     * Logs will display the activity title that was interacted with.
     *
     * @return  string  -  Title of the activity that should be shown on logs.
     */
    public function feed_title()
    {
        return $this->seoTitle();
    }

    /**
     * Logs will create an activity link to allow the user to edit upon click.
     *
     * @return  string  -  Url link that activity will be redirected to.
     */
    public function feed_url()
    {
        return url("admin/pages/edit/{$this->slug()}");
    }

    public function setSitemap($boolean)
    {
        if ($boolean == true) {
            return $this->enableSitemap();
        }

        return $this->disableSitemap();
    }

    public function setMenuID($integer)
    {
        $this->setAttribute('menu_id', $integer);

        return $this;
    }

    /**
     * @return Redirect|mixed
     */
    public function redirect()
    {
        return $this->hasOne(Redirect::class, 'from', 'id');
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
    public function creator()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
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
     * Set the creator id to the creator column.
     *
     * @param int $integer
     * @return $this
     */
    public function setCreatorID(int $integer)
    {
        return $this->setAttribute('creator_id', $integer);
    }
}
