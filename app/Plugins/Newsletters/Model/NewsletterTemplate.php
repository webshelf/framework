<?php

namespace App\Plugins\Newsletters\Model;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsletterTemplate.
 */
class NewsletterTemplate extends Model
{
    /*
    * Laravel Searchable Model.
    *
    * @ https://laravel.com/docs/5.3/scout#installation
    */
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletter_templates';

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
