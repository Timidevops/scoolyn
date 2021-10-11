<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Tenant\Transaction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerifyFlutterwaveCallbackMiddleware
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
        $transactionReference = $request->get('tx_ref') ?? null;

        $transactionId      = $request->get('transaction_id') ?? null;

        if(! Transaction::query()->where('reference','=', $transactionReference)->exists()){
            abort(404, 'Invalid transaction');
        }

        if( Transaction::query()->where('payment_method_reference','=',$transactionId)->exists()) {
            Session::flash('warningFlash', 'Payment has been processed');
            return redirect()->route('listWardFee');
        }

        return $next($request);
    }
}
