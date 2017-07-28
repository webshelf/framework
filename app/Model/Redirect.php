<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/07/2016
 * Time: 20:12.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Redirect.
 *
 * @property Page toPage
 * @property Page fromPage
 */
class Redirect extends Engine
{
    use SoftDeletes;

    protected $table = 'redirects';

    protected $softDeletes = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function id()
    {
        return $this->getAttribute('id');
    }

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
