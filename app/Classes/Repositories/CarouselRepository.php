<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 08/01/2017
 * Time: 00:05.
 */

namespace App\Classes\Repositories;

use App\Model\Carousel;

/**
 * Class SliderRepository.
 */
class CarouselRepository extends Carousel
{
    /**
     * @param int $integer
     * @return mixed|Carousel
     */
    public function whereID(int $integer)
    {
        return $this->where('id', $integer)->with('slides')->first();
    }

    /**
     * @return CarouselRepository[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function allWithSlides()
    {
        return $this->with('slides')->get();
    }
}
