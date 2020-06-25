<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ACLMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!$request->user()->hasRole($role))
            return redirect()->to(Route('home'))->withErrors('Unauthorised.');
        return $next($request);
    }
}
