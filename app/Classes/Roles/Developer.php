<?php

namespace App\Classes\Roles;

use Closure;
use App\Model\Account;
use App\Classes\Roles\Interfaces\RoleInterface;

/**
 * Undocumented class.
 */
class Developer implements RoleInterface
{
    /**
     * The role ID of the administrator.
     *
     * @var int
     */
    public static $key = 1;

    /**
     * Apply the role logic to the account.
     *
     * @param Account $account
     * @return bool
     */
    public function apply(Account $account)
    {
        return $account->setAttribute('role_id', self::$key);
    }

    /**
     * Validate the role logic.
     *
     * @return bool
     */
    public function validate(Account $account)
    {
        return $account->role_id <= self::$key;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->validate()) {
            return $next($request);
        }
    }
}
