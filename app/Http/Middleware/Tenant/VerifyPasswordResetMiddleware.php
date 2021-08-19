<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class VerifyPasswordResetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Password::getUser($request->only('email'));

        if( ! $user ){
            abort(404);
        }

        if( ! Password::tokenExists($user,$request->input('token')) ){
            abort(404);
        }

        return $next($request);
    }
}
