<?php

namespace App\Http\Controllers\Landlord\AdminDomain\Subscription;

use App\Actions\Landlord\Plan\CreateNewPlanAction;
use App\Http\Controllers\Controller;
use App\Models\Landlord\Feature;
use App\Models\Landlord\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PlansController extends Controller
{
    public function index()
    {
        return view('Landlord.adminDomain.pages.subscription.plan.index', [
            'plans'      => Plan::all(),
            'totalPlans' => Plan::query()->count(),
        ]);
    }

    public function create()
    {
        return view('Landlord.adminDomain.pages.subscription.plan.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'price' => ['required'],
            'signupFee' => ['required'],
            'invoiceInterval' => ['required'],
            'currency' => ['required'],
        ]);

        (new CreateNewPlanAction)->execute(camel_to_snake($request->except('_token')));

        Session::flash('successFlash', 'Plan added successfully!!!');

        return back();
    }

    public function edit(string $uuid)
    {
        return view('Landlord.adminDomain.pages.subscription.plan.edit', [
            'plan' => Plan::whereUuid($uuid)->firstOrFail(),
            'features' => Plan::whereUuid($uuid)->first()->features,
            'newFeatures' => Feature::query()->get(['uuid', 'name', 'description', 'value']),
        ]);
    }
}
