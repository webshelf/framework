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
class SettingsRepository
{
    /**
     * The model for eloquent access.
     *
     * @var Builder
     */
    private $model;

    /**
     * AccountRepository constructor.
     *
     * @param Setting $model
     */
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function all() : Collection
    {
        return $this->model->get();
    }

    /**
     * Return a single model where the integer matches.
     *
     * @param $integer
     * @return array|\stdClass|Setting
     */
    public function whereID(int $integer)
    {
        return $this->model->where('id', $integer)->first();
    }

    /**
     * @param string $string
     * @return Setting|array|null|\stdClass
     */
    public function whereKey(string $string) : Setting
    {
        return $this->model->where('key', $string)->first();
    }
}
