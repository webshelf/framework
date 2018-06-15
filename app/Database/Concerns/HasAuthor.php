<?php

namespace App\Database\Concerns;

use App\Database\Observers\Authorable;

/**
 * Undocumented trait.
 */
trait HasAuthor
{
    /**
     * Authorable Boot logic.
     *
     * @return void
     */
    public static function bootAuditable()
    {
        static::observe(new Authorable());
    }
}
