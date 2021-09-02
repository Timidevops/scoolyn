<?php

namespace App\Http\Middleware\Landlord;

use App\Models\Tenant\ScoolynTenant;
use Closure;
use Illuminate\Http\Request;

class CheckCurrentTenantMiddleware
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
        if ( ! ScoolynTenant::checkCurrent() ) {
            return redirect()->to('http://scoolyn.com');
        }

        return $next($request);
    }
}
