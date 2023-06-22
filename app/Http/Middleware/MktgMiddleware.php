<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class MktgMiddleware
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
        $user = new User;

        if ($user->isAdmin($request->user()->id) || $user->isMKTG($request->user()->id)) {
            return $next($request);
        }

        return abort(403, 'This action is unauthorized.');
    }
}
