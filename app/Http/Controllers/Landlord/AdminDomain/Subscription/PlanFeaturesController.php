<?php

namespace App\Http\Controllers\Landlord\AdminDomain\Subscription;

use App\Actions\Landlord\Plan\CreateNewPlanFeatureAction;
use App\Http\Controllers\Controller;
use App\Models\Landlord\Feature;
use App\Models\Landlord\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PlanFeaturesController extends Controller
{
    public function store(Request $request, string $uuid)
    {
        $plan = Plan::whereUuid($uuid)->first();

        if ( ! $plan ){
            Session::flash('errorFlash', 'Error processing request');

            return back();
        }

        $this->validate($request, [
            'featureId' => ['required', 'exists:features,uuid'],
            'value' => ['required'],
        ]);

        $feature = Feature::whereUuid($request->input('featureId'))->first();

        (new CreateNewPlanFeatureAction)->execute($plan, [
            'name' => $feature->name,
            'value' => $request->input('value'),
            'description' => $feature->description,
        ]);

        Session::flash('successFlash', 'Feature added successfully!!!');

        return back();
    }
}
