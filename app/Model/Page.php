<?php

namespace App\Model;

use Carbon\Carbon;
use OwenIt\Auditing\Auditable;
use App\Classes\Interfaces\AuditInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Pages.
 *
 * @property Account getPublisher
 * @property Redirect redirect
 * @property Menu $menu
 *
 * @property int $id
 * @property string $slug
 * @property string $content
 * @property string $banner
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property int $views
 * @property bool $sitemap
 * @property bool $enabled
 * @property string $plugin
 * @property int $editable
 * @property int $creator_id
 * @property int $editor_id
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Page extends EloquentModel implements AuditInterface
{
    /*
     * Laravel Deleting.
     * @ https://laravel.com/docs/5.5/eloquent#soft-deleting
     */
    use SoftDeletes;
    /*
     * Laravel Audits.
     * @ http://www.laravel-auditing.com
     */
    use Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['seo_title', 'slug'];

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
    protected $auditExclude = [
        'views',
    ];

    /**
     * Increment the view count of the page.
     *
     * @return int
     */
    public function incrementViews()
    {
        return $this->views = $this->views + 1;
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
     * Generate a link for the audit log.
     *
     * @return string
     */
    public function auditTitle()
    {
        return $this->seo_title;
    }

    /**
     * Generate a url to the audited data.
     *
     * @return mixed
     */
    public function auditUrl()
    {
        return route('admin.pages.edit', $this->slug);
    }

    /**
     * Generate a url slug based on the relationship this belongs to.
     *
     * @return string
     */
    public function slug()
    {
        if ($this->menu && $this->menu->parent) {
            if ($this->menu->parent->page->slug != 'index') {
                return sprintf('%s/%s', strtolower($this->menu->parent->title), $this->slug);
            }
        }

        return $this->slug;
    }
}
