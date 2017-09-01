<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 12/10/2016
 * Time: 20:14.
 */

namespace App\Classes\Repositories;

use App\Model\Account;

/**
 * Class AccountRepository.
 */
class AccountRepository extends Account
{
    /**
     * @param int $integer
     * @return Account|array|\stdClass
     */
    public function whereID(int $integer) : Account
    {
        return $this->where('id', $integer)->first();
    }

    /**
     * @param string $string
     * @return array|\stdClass|Account
     */
    public function whereEmail(string $string) : Account
    {
        return $this->where('email', $string)->first();
    }
}
