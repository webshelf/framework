<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/04/2016
 * Time: 13:05.
 */

namespace App\Classes\Repositories;

use App\Model\Article;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class NewsRepository.
 */
class ArticleRepository extends Article
{
    /**
     * @param int $integer
     * @return mixed
     */
    public function paginateEnabled($integer = 7)
    {
        return $this->where('publish', true)->paginate($integer);
    }

    /**
     * @param $string
     * @return Article
     */
    public function whereSlug($string) : Article
    {
        return $this->where('slug', $string)->first();
    }
}
