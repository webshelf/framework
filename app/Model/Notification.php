<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 01/12/2016
 * Time: 14:46.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Notification.
 */
class Notification extends Engine
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'notifications';

    /**
     * @var bool
     */
    protected $softDelete = true;

    /**
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at', 'updated_at', 'read_at'];

    public function id()
    {
        return $this->getAttribute('id');
    }

    public function setID(int $integer)
    {
        $this->setAttribute('id', $integer);

        return $this;
    }

    public function level()
    {
        return $this->getAttribute('level');
    }

    public function setLevel(int $integer)
    {
        $this->setAttribute('level', $integer);

        return $this;
    }

    public function message()
    {
        return $this->getAttribute('message');
    }

    public function setMessage(string $text)
    {
        $this->setAttribute('message', $text);

        return $this;
    }

    public function readAt()
    {
        return $this->getAttribute('read_at');
    }

    public function setReadAt($timestamp)
    {
        $this->setAttribute('read_at', $timestamp);

        return $this;
    }

    public function deletedAt()
    {
        return $this->getAttribute('deleted_at');
    }

    public function setDeletedAt($timestamp)
    {
        $this->setAttribute('deleted_at', $timestamp);

        return $this;
    }

    public function updatedAt()
    {
        return $this->getAttribute('updated_at');
    }

    public function setUpdatedAt($timestamp)
    {
        $this->setAttribute('updated_at', $timestamp);

        return $this;
    }

    public function createdAt()
    {
        return $this->getAttribute('created_at');
    }

    public function setCreatedAt($timestamp)
    {
        $this->setAttribute('created_at', $timestamp);

        return $this;
    }
}
