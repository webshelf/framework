<?php

namespace App\Plugins\Newsletters\Model;

use Carbon\Carbon;
use App\Model\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Newsletter.
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $emailCount
 * @property bool $deliveryStatus
 * @property int $editor_id
 * @property int $creator_id
 *
 * @property Account $creator
 * @property Account $editor
 *
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Newsletter extends Model
{
    // constant values.
    const VIEW_NEWSLETTER_SUCCESS = 'newsletter.success';

    /*
     * Laravel Searchable Model.
     *
     * @ https://laravel.com/docs/5.3/scout#installation
     */
    // use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletters';

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
    protected $dates = ['updated_at', 'created_at'];
}
