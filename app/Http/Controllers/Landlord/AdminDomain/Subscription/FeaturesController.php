<?php

namespace App\Http\Controllers\Landlord\AdminDomain\Subscription;

use App\Actions\Landlord\Feature\CreateNewFeatureAction;
use App\Http\Controllers\Controller;
use App\Models\Landlord\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeaturesController extends Controller
{
    public function index()
    {
        return view('landlord.adminDomain.pages.subscription.feature.index', [
            'features' => Feature::all(),
            'totalFeatures' => Feature::query()->count(),
        ]);
    }

    public function create()
    {
        return view('landlord.adminDomain.pages.subscription.feature.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'value' => ['required'],
        ]);

        (new CreateNewFeatureAction)->execute(camel_to_snake($request->except('_token')));

        Session::flash('successFlash', 'Feature added successfully!!!');

        return back();
    }
}
