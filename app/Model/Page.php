<?php

namespace App\Model;

use Carbon\Carbon;
use Laravel\Scout\Searchable;
use Illuminate\Support\Collection;
use App\Classes\Interfaces\Linkable;
use App\Plugins\Pages\Model\PageTypes;
use App\Plugins\Pages\Model\PageOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Model\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Pages.
 *
 * @property Account getPublisher
 * @property Redirect redirect
 * @property Menu $menu
 *
 * @property int $id
 * @property string $identifier
 * @property string $prefix
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property string $banner
 * @property string $heading
 * @property string $description
 * @property string $keywords
 * @property int $views
 * @property int $type
 * @property int $option
 * @property int $creator_id
 * @property int $editor_id
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @return Page|Collection|Builder
 */
class Page extends Model implements Linkable
{
    /*
     * Laravel Deleting.
     * 
     * @ https://laravel.com/docs/5.5/eloquent#soft-deleting
     */
    use SoftDeletes;
    /*
     * Laravel Searchable Model.
     *
     * @ https://laravel.com/docs/5.3/scout#installation
     */
    use Searchable;

    /*
     * Log users activity on this model.
     * 
     * @ https://docs.spatie.be/laravel-activitylog/v2/advanced-usage/logging-model-events
     */
    use LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The table date columns, casted to Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The activity logging strings to be used.
     * 
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$eventName} a page titled {$this->seo_title}";
    }

    /**
     * A page belongs to a single menu.
     *
     * @return Menu|BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id', 'page_id');
    }

    /**
     * A page can have a redirect to another url, external or internal.
     *
     * @return Redirect|\Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function redirect()
    {
        return $this->hasOne(Redirect::class, 'from', 'id');
    }

    /**
     * Get the creator model of the eloquent model.
     *
     * @return Account|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    /**
     * Get the creator model of the eloquent model.
     *
     * @return Account|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo(Account::class, 'editor_id', 'id');
    }

    /**
     * The resource that is linked to this.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|Collection
     */
    public function link()
    {
        return $this->morphOne(Link::class, 'from');
    }

    /**
     * The resource to which this is linked to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|Collection
     */
    public function linked()
    {
        return $this->morphMany(Link::class, 'to');
    }

    /**
     * The url that is used to view this model.
     *
     * @return string
     */
    public function route()
    {
        if ($this->prefix) {
            return "{$this->prefix}/{$this->slug}";
        }

        return "{$this->slug}";
    }

        /**
     * The name of the current model object.
     *
     * @deprecated
     * @return string
     */
    public function name()
    {
        return "{$this->seo_title}";
    }

    /**
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['seo_title'] = $value;

        $this->attributes['slug'] = str_slug($value);
    }

    public function getHeadingAttribute()
    {
        return $this->attributes['seo_title'];
    }

    public function setHeadingAttribute($value)
    {
        $this->attributes['seo_title'] = $value;
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['seo_description'];
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['seo_description'] = $value;
    }

    public function setKeywordsAttribute($value)
    {
        $this->attributes['seo_keywords'] = $value;
    }

    public function getKeywordsAttribute()
    {
        return $this->attributes['seo_keywords'];
    }

    /**
     * Return the status if the page has the options specified.
     *
     * @param PageOptions $options Values of the required options
     *
     * @return bool the returned condition
     */
    public function hasOption($options)
    {
        $options = explode('|', $options);

        foreach ($options as $option) {
            $constant = constant(sprintf('%s::OPTION_%s', PageOptions::class, strtoupper($option)));

            if ($this->option & $constant) {
                return $constant;
            }
        }

        return false;
    }

    /**
     * Return if the current page type matches the condition giving.
     *
     * @param PageTypes $type The type required for the condition
     *
     * @return bool The condition of the function.
     */
    public function isType(string $type)
    {
        $constant = constant(sprintf('%s::TYPE_%s', PageTypes::class, strtoupper($type)));

        return $this->type & $constant;
    }
}
