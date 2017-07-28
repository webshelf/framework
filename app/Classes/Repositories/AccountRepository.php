<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 12/10/2016
 * Time: 20:14.
 */

namespace App\Classes\Repositories;

use App\Model\Account;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AccountRepository.
 */
class AccountRepository
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
     * @param Account $model
     */
    public function __construct(Account $model)
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
     * @return Account|array|\stdClass
     */
    public function whereID(int $integer) : Account
    {
        return $this->model->where('id', $integer)->first();
    }

    /**
     * @param string $string
     * @return array|\stdClass|Account
     */
    public function whereEmail(string $string) : Account
    {
        return $this->model->where('email', $string)->first();
    }
}
