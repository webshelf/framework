<?php

namespace App\Plugins\Newsletters\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsletterUser.
 *
 * @property int $id
 * @property string $email
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class NewsletterUser extends Model
{
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
    protected $table = 'newsletter_users';

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
