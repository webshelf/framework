<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 12:18.
 */

namespace App\Model;

use App\Model\Traits\LogsActivity;
use App\Database\Concerns\ActivityLogging;

/**
 * Class Setting.
 */
class Setting extends Model
{
    /*
     * Log users activity on this model.
     *
     * @ https://docs.spatie.be/laravel-activitylog/v2/advanced-usage/logging-model-events
     */
    use ActivityLogging;

    protected $table = 'settings';

    protected $dates = ['updated_at'];

    /**
     * The activity logging strings to be used.
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$eventName} the setting for {$this->key}";
    }

    public function id()
    {
        return $this->getAttribute('id');
    }

    public function key()
    {
        return $this->getAttribute('key');
    }

    public function name()
    {
        return $this->getAttribute('name');
    }

    public function value()
    {
        return $this->getAttribute('value');
    }

    public function description()
    {
        return $this->getAttribute('description');
    }

    // shadow is the name - default -name, since php 5.6 does not support
    // the keywords as function names.
    public function shadow()
    {
        return $this->getAttribute('default');
    }

    /**
     * If a value exists, return that, otherwise return shadow.
     *
     * @return mixed
     */
    public function current()
    {
        return $this->value() ?: $this->shadow();
    }

    public function getUpdatedAt()
    {
        return $this->getAttribute('updated_at');
    }

    /**
     * ==========================================================.
     *
     *   SET THE ATTRIBUTES OF THE MODEL
     *
     * ==========================================================
     */
    public function setKey($string)
    {
        $this->setAttribute('key', $string);

        return $this;
    }

    public function setName($string)
    {
        $this->setAttribute('name', $string);

        return $this;
    }

    public function setValue($string)
    {
        $this->setAttribute('value', $string);

        return $this;
    }

    public function setShadow(string $string)
    {
        $this->setAttribute('default', $string);

        return $this;
    }

    public function setDescription($string)
    {
        $this->setAttribute('description', $string);

        return $this;
    }
}
