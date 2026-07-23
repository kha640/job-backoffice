<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check Has No Access
        if ( auth()->check() ) {
            $userRole = auth()->user()->role;
            $hasAccess = in_array( $userRole , $roles);

            if ( !$hasAccess ) {
                return abort(403);
            }
        }

        // Has Access
        return $next($request);
    }
}
