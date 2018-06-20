<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Classes\Roles\Disabled;
use App\Classes\Roles\Exceptions\UnauthorizedRoleException;
use Illuminate\Support\Facades\Auth;

class PermissionGateway
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (account()->hasRole(new Disabled)) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['error' => 'Access to dashboard disabled']);
        }

        return $next($request);
    }
}
