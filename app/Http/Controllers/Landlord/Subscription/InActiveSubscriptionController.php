<?php

namespace App\Http\Controllers\Landlord\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ScoolynTenant;
use Illuminate\Http\Request;

class InActiveSubscriptionController extends Controller
{
    public function index()
    {
        if ( ScoolynTenant::isSubscriptionActive() ){
            return redirect()->route('dashboard');
        }

        return view('landlord.pages.subscription.notActive.index');
    }
}
