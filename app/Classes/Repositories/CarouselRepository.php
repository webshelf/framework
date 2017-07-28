<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 08/01/2017
 * Time: 00:05.
 */

namespace App\Classes\Repositories;

use App\Model\Carousel;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SliderRepository.
 */
class CarouselRepository
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
     * @param Carousel $model
     */
    public function __construct(Carousel $model)
    {
        $this->model = $model;
    }

    /**
     * Return a collection of all accounts.
     */
    public function all() : Collection
    {
        return $this->model->get();
    }

    /**
     * @param int $integer
     * @return Carousel|array|\stdClass
     */
    public function whereID(int $integer) : Carousel
    {
        return $this->model->where('id', $integer)->first();
    }
}
