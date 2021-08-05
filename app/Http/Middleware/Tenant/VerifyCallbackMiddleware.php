<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Tenant\Transaction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerifyCallbackMiddleware
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
        $transactionReference = $request->get('transactionReference') ?? null;

        $clientReference      = $request->get('clientReference') ?? null;

        if(! Transaction::query()->where('reference','=',$clientReference)->exists()){
            abort(404, 'Invalid transaction');
        }

        if( Transaction::query()->where('payment_method_reference','=',$transactionReference)->exists()) {
            Session::flash('warningFlash', 'Payment has been processed');
            return redirect()->route('listWardFee');
        }

        return $next($request);
    }
}
