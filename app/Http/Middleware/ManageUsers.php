<?php

namespace App\Http\Middleware;

use App\Http\Models\UserRoles;
use Closure;
use Illuminate\Support\Facades\Auth;

class ManageUsers
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
        if(Auth::user()->cannot('manage_users', UserRoles::class)){
            abort(401);
        }
        return $next($request);

    }
}
