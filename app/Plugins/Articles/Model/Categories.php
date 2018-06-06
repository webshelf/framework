<?php

namespace App\Plugins\Articles\Model;

use Carbon\Carbon;
use App\Model\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ArticleCategory.
 *
 * @property string $title
 * @property string $slug
 * @property int $status
 * @property int $editor_id
 * @property int $creator_id
 *
 * @property Account $editor
 * @property Account $creator
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Categories extends Model
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
    protected $table = 'article_categories';

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
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
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
     * Slug the title for url usage.
     *
     * @return string
     */
    public function getSlugAttribute()
    {
        return str_slug($this->getAttribute('title'));
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
}
