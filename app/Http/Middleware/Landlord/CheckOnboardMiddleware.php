<?php

namespace App\Http\Middleware\Landlord;

use App\Models\Landlord\SchoolAdmin;
use Closure;
use Illuminate\Http\Request;

class CheckOnboardMiddleware
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
        $schoolAdmin = SchoolAdmin::query()
            ->where('uuid', $request->route()->parameter('uuid'))
            ->firstOrFail();

        if( $schoolAdmin->isOnboardDone() ){
            abort('404');
        }

        return $next($request);
    }
}
