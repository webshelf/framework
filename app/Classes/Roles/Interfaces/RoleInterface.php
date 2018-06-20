<?php

namespace App\Classes\Roles\Interfaces;

use Closure;
use App\Model\Account;

/**
 * Undocumented class
 */
interface RoleInterface
{
    /**
     * Apply the role logic to the account.
     *
     * @param Account $account
     * @return boolean
     */
    public function apply(Account $account);
    
    /**
     * Validate the role logic
     *
     * @return boolean
     */ 
    public function validate(Account $account);


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next);
}