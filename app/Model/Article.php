<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 19/04/2016
 * Time: 17:42.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class News.
 */
class Article extends Engine
{
    protected $table = 'articles';

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['created_at', 'deleted_at', 'updated_at', 'publish_date', 'event_date'];

    public function id()
    {
        return $this->getAttribute('id');
    }

    public function title()
    {
        return $this->getAttribute('title');
    }

    public function slug()
    {
        return $this->getAttribute('slug');
    }

    public function content()
    {
        return $this->getAttribute('content');
    }

    public function category_id()
    {
        return $this->getAttribute('category');
    }

    public function publish()
    {
        return $this->getAttribute('publish');
    }

    public function publishDate()
    {
        return $this->getAttribute('publish_date');
    }

    public function unpublish_date()
    {
        return $this->getAttribute('unpublish_date');
    }

    public function event_date()
    {
        return $this->getAttribute('event_date');
    }

    public function creator_id()
    {
        return $this->getAttribute('creator_id');
    }

    public function modified_id()
    {
        return $this->getAttribute('modified_id');
    }

    public function alt_text()
    {
        return $this->getAttribute('alt_text');
    }

    public function seo_title()
    {
        return $this->getAttribute('seo_title');
    }

    public function seo_keywords()
    {
        return $this->getAttribute('seo_keywords');
    }

    public function seo_description()
    {
        return $this->getAttribute('seo_description');
    }

    public function updated_at()
    {
        return $this->getAttribute('updated_at');
    }

    public function deleted_at()
    {
        return $this->getAttribute('deleted_at');
    }

    public function created_at()
    {
        return $this->getAttribute('created_at');
    }

    /**
     * Returns relationship data.
     *
     * @return Account|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    public function modifier()
    {
        return $this->belongsTo(Account::class, 'modified_id', 'id');
    }

    public function setTitle($string)
    {
        return $this->setAttribute('title', $string);
    }

    public function setSlug($string)
    {
        return $this->setAttribute('slug', $string);
    }

    public function setContent($longText)
    {
        return $this->setAttribute('content', $longText);
    }

    public function setSeoTitle($string)
    {
        return $this->setAttribute('seo_title', $string);
    }

    public function setSeoKeywords($string)
    {
        return $this->setAttribute('seo_keywords', $string);
    }

    public function setSeoDescription($string)
    {
        return $this->setAttribute('description', $string);
    }

    public function enableArticle()
    {
        return $this->setPublish(true);
    }

    public function disableArticle()
    {
        return $this->setPublish(false);
    }

    public function setEventDate($timestamp)
    {
        return $this->setAttribute('event_date', $timestamp);
    }

    public function setPublish($boolean)
    {
        return $this->setAttribute('publish', $boolean ? true : false);
    }
}
