<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /*
        * Handle an incoming request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \Closure  $next
        * @return mixed
    */
    public function handle(Request $request, Closure $next, string $role)
    {
        $roles = explode("|", $role);
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403);
        }
        return $next($request);
    }
}
