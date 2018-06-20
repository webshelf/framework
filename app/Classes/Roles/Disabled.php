<?php

namespace App\Classes\Roles;

use Closure;
use App\Model\Account;
use App\Classes\Roles\Interfaces\RoleInterface;

/**
 * Undocumented class
 */
class Disabled implements RoleInterface
{

    /**
     * The role ID of the administrator
     *
     * @var integer
     */
    public static $key = 4;

    /**
     * Apply the role logic to the account.
     *
     * @param Account $account
     * @return boolean
     */
    public function apply(Account $account)
    {
        return $account->update(['role_id' => self::$key]);
    }

    /**
     * Validate the role logic
     *
     * @return boolean
     */ 
    public function validate(Account $account)
    {
        return $account->role_id == self::$key;
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
        return $next($request);
    }
}