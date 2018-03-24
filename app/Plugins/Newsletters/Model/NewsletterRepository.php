<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 02/03/2018
 * Time: 11:37.
 */

namespace App\Plugins\Newsletters\Model;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Classes\Repositories\BaseRepository;

/**
 * Class NewsletterRepository.
 */
class NewsletterRepository extends BaseRepository
{
    /**
     * @var Newsletter|Builder|Collection
     */
    protected $model;

    /**
     * PageRepository constructor.
     *
     * @param Newsletter $model
     */
    public function __construct(Newsletter $model)
    {
        $this->model = $model;
    }
}
