<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Redirect.
 *
 * @property int $id
 * @property Page $fromPage
 * @property Page $toPage
 * @property int $creator_id
 * @property int $modifier_id
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Redirect extends Model
{
    /*
     * Laravel Deleting.
     * @ https://laravel.com/docs/5.5/eloquent#soft-deleting
     */
    use SoftDeletes;

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
    protected $table = 'redirects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['from', 'to'];

    /**
     * The activity logging strings to be used.
     * 
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$eventName} a redirect to {$this->toPage->seo_title}";
    }

    /**
     * The table date columns, casted to Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function from()
    {
        if (is_numeric($this->getAttribute('from'))) {
            return $this->fromPage->route();
        } else {
            return $this->getAttribute('from');
        }
    }

    public function setFrom($string)
    {
        $this->setAttribute('from', $string);

        return $this;
    }

    public function to()
    {
        if (is_numeric($this->getAttribute('to'))) {
            return $this->toPage->route();
        } else {
            return $this->getAttribute('to');
        }
    }

    public function setTo($string)
    {
        $this->setAttribute('to', $string);

        return $this;
    }

    /**
     * @param int $integer
     * @return $this
     */
    public function setCreatorID(int $integer)
    {
        $this->setAttribute('creator_id', $integer);

        return $this;
    }

    public function creator()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    public function modifier()
    {
        if ($this->getAttribute('modifier_id')) {
            return $this->belongsTo(Account::class, 'modifier_id', 'id');
        }
    }

    public function deleted_at()
    {
        return $this->getAttribute('deleted_at');
    }

    public function updated_at()
    {
        return $this->getAttribute('updated_at');
    }

    public function created_at()
    {
        return $this->getAttribute('created_at');
    }

    public function isEnabled()
    {
        return $this->deleted_at() ? false : true;
    }

    public function lastEditor()
    {
        return $this->modifier() ?: $this->creator();
    }

    /**
     * @return Page|mixed
     */
    public function fromPage()
    {
        return $this->belongsTo(Page::class, 'from', 'id');
    }

    /**
     * @return Page|mixed
     */
    public function toPage()
    {
        return $this->belongsTo(Page::class, 'to', 'id');
    }
}
