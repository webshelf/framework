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
class CarouselRepository extends Carousel
{
    /**
     * @param int $integer
     * @return Carousel
     */
    public function whereID(int $integer) : Carousel
    {
        return $this->where('id', $integer)->first();
    }
}
