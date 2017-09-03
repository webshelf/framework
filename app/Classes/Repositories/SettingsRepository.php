<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 17:35.
 */

namespace App\Classes\Repositories;

use App\Model\Setting;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SettingsRepository.
 */
class SettingsRepository extends Setting
{

    /**
     * Return a single model where the integer matches.
     *
     * @param $integer
     * @return SettingsRepository|array|\Illuminate\Database\Eloquent\Model
     */
    public function whereID(int $integer)
    {
        return $this->where('id', $integer)->first();
    }

    /**
     * @param string $string
     * @return Setting
     */
    public function firstKey(string $string)
    {
        return $this->where('key', $string)->first();
    }
}
