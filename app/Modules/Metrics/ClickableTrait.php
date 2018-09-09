<?php
/**
 * Created by PhpStorm.
 * User: markhester
 * Date: 08/09/2018
 * Time: 17:41.
 */

namespace App\Modules\Metrics;

use App\Modules\Metrics\Models\Clicks;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait ClickableTrait.
 */
trait ClickableTrait
{
    /**
     * @return Clicks|MorphMany
     */
    public function clicks()
    {
        return $this->morphMany(Clicks::class, 'clickable');
    }
}
