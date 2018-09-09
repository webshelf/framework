<?php

namespace App\Http\Middleware;

use Closure;

class RequiresRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (! account()->hasRole(ucfirst($role))) {
            return redirect()->route('dashboard')->withErrors(['error' => 'You do not have permission to use the requested resource.']);
        }

        return $next($request);
    }
}
