<?php

namespace App\Model;

use Carbon\Carbon;
use App\Classes\ReadTime;
use Laravel\Scout\Searchable;
use App\Classes\Interfaces\Linkable;
use App\Classes\Repositories\PageRepository;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Article.
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property string $featured_img
 * @property int $category_id
 * @property int $editor_id
 * @property int $creator_id
 * @property bool $status
 *
 * @property ArticleCategory $category
 *
 * @property Account $creator
 * @property Account $editor
 *
 * @property Carbon $publish_date
 * @property Carbon $unpublish_date
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Article extends BaseModel implements Linkable
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
     * Article is viewable by all visitors.
     */
    const STATUS_PUBLIC = 1;

    /**
     * Article is only viewable by those authenticated.
     */
    const STATUS_PRIVATE = 0;

    /**
     * Default attributes associated with the model.
     *
     * @var array
     */
    protected $attributes = [
        'status' => SELF::STATUS_PUBLIC,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

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
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'publish_date', 'unpublish_date'];

    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [];

    /**
     * @return ArticleCategory|HasOne
     */
    public function category()
    {
        return $this->hasOne(ArticleCategory::class, 'id', 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    public function editor()
    {
        return $this->belongsTo(Account::class, 'editor_id', 'id');
    }

    /**
     * Set the title of the article, and the slug.
     *
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * The url that is used to view this model.
     *
     * @return string
     */
    public function route()
    {
        /** @var Page $page */
        $page = app(PageRepository::class)->whereidentifier('articles');

        if ($this->category) {
            return "{$page->route()}/{$this->getAttribute('slug')}";
        }

        return "{$page->route()}/{$this->getAttribute('slug')}";
    }

    /**
     * The name of the current model object.
     *
     * @return string
     */
    public function name()
    {
        return $this->getAttribute('title');
    }

    /**
     * @param int $amount
     * @return int
     */
    public function incrementView(int $amount = 1)
    {
        return $this->increment('views', $amount);
    }

    /**
     * Check if the article has a featured image available for viewing.
     *
     * @return bool Condition of the image being available.
     */
    public function hasFeaturedImage()
    {
        return $this->getAttribute('featured_img') != '';
    }

    /**
     * Return the estimated read time of the article.
     *
     * @return float The estimation of time.
     */
    public function readTime()
    {
        return ReadTime::InMinutes($this->getAttribute('content'));
    }

    /**
     * Get the total count of typed words in the article.
     *
     * @return int The total count of words.
     */
    public function countWords()
    {
        return ReadTime::countWords($this->getAttribute('content'));
    }
}
