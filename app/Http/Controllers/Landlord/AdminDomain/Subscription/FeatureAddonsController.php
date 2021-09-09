<?php

namespace App\Http\Controllers\Landlord\AdminDomain\Subscription;

use App\Actions\Landlord\Feature\CreateNewFeatureAddonAction;
use App\Http\Controllers\Controller;
use App\Models\Landlord\Feature;
use App\Models\Landlord\FeatureAddon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeatureAddonsController extends Controller
{
    public function index()
    {
        return view('Landlord.adminDomain.pages.subscription.featureAddon.index', [
            'features' => Feature::query()->get(['name', 'uuid', 'description']),
            'totalFeatureAddons' => FeatureAddon::query()->count(),
            'featureAddons' => FeatureAddon::query()->get(['name', 'value']),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'featureId' => ['required', 'exists:features,uuid'],
            'value' => ['required'],
            'amount' => ['required'],
        ], [
            'featureId.required' => 'Kindly select a feature',
            'value.required' => 'Kindly input addon value',
        ]);

        (new CreateNewFeatureAddonAction)->execute([
            'name' => Feature::whereUuid($request->input('featureId'))->first()->name,
            'value' => $request->input('value'),
            'amount' => $request->input('amount'),
        ]);

        Session::flash('successFlash', 'Addon added successfully!!!');

        return back();
    }
}
