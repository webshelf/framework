<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/03/2016
 * Time: 21:43.
 */

namespace App\Model;

/**
 * Class Dalm.
 */
class Migration extends Engine
{
    protected $table = 'updates';

    protected $dates = ['execution_date'];

    public function id()
    {
        return $this->getAttribute('id');
    }

    public function md5()
    {
        return md5($this->id());
    }

    public function batch()
    {
        return $this->getAttribute('batch');
    }

    public function migration()
    {
        return $this->getAttribute('migration');
    }

    public function execution_date()
    {
        return $this->getAttribute('created_at');
    }
}
