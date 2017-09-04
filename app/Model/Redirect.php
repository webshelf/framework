<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Redirect.
 *
 * @property int $id
 * @property mixed $fromPage
 * @property mixed $to
 * @property int $creator_id
 * @property int $modifier_id
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Redirect extends EloquentModel
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
    protected $table = 'redirects';

    /**
     * The table date columns, casted to Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];



    public function from()
    {
        if (is_numeric($this->getAttribute('from'))) {
            return makeSlug($this->fromPage);
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
            return makeSlug($this->toPage);
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
