<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/07/2016
 * Time: 20:37.
 */

namespace App\Classes\Repositories;

use App\Model\Redirect;

/**
 * Class RedirectRepository.
 */
class RedirectRepository extends Redirect
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|void|static[]
     */
    public function withRelationship()
    {
        return $this->whereHas('fromPage')->whereHas('toPage')->get();
    }

    /**
     * @param int $integer
     * @return Redirect|array|\stdClass
     */
    public function whereID(int $integer) : Redirect
    {
        return $this->where('id', $integer)->first();
    }
}
