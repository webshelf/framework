<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/07/2016
 * Time: 20:37.
 */

namespace App\Classes\Repositories;

use App\Model\Redirect;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RedirectRepository.
 */
class RedirectRepository extends Redirect
{

    /**
     * @param int $integer
     * @return Redirect|array|\stdClass
     */
    public function whereID(int $integer) : Redirect
    {
        return $this->where('id', $integer)->first();
    }
}
