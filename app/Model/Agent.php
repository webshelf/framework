<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 05/09/2017
 * Time: 07:00.
 */

namespace App\Model;

use Carbon\Carbon;

/**
 * @property int $id
 * @property string $ip_address
 * @property string $browser
 * @property int $page_id
 *
 * @property Page $page
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Class Request
 */
class Agent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agents';

    /**
     * @return Page|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
