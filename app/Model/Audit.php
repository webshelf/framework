<?php

namespace App\Model;

use OwenIt\Auditing\Models\Audit as Auditing;

/**
 * Class Audit.
 */
class Audit extends Auditing
{
    public function test()
    {
        return $this->belongsTo($this->getAttribute('auditable_type'), 'auditable_id', 'id');
    }
}
