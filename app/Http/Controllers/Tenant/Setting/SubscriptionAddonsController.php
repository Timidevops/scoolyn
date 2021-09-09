<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Landlord\Transaction\CreateNewTransactionAction;
use App\Actions\Tenant\Checkout\InitializeCheckoutAction;
use App\Http\Controllers\Controller;
use App\Models\Landlord\Feature;
use App\Models\Landlord\FeatureAddon;
use App\Models\Tenant\ScoolynTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriptionAddonsController extends Controller
{
    public function index()
    {
        return view('Tenant.pages.setting.subscriptionSetting.addon.student.index', [
            'featureAddons' => FeatureAddon::whereName(Feature::TOTAL_NUMBER_OF_STUDENT)->get(['name', 'value', 'amount', 'uuid']),
        ]);
    }

    public function store(string $uuid)
    {
        $featureAddon = FeatureAddon::whereUuid($uuid)->first();

        if ( ! $featureAddon ){
            Session::flash('successFlash', 'Error processing request.');

            return back();
        }

        $reference = generateUniqueReference('12','rp_');

        //call checkout initiation
        $response = (new InitializeCheckoutAction)->execute([
            'reference'   => $reference,
            'amount'      => $featureAddon->amount,
            'email'       => ScoolynTenant::current()->schoolAdmin->email,
            'callbackUrl' => route('addonPaymentCallback'),
        ]);

        if ( ! $response ){
            Session::flash('errorFlash', 'Error processing request.');

            return back();
        }

        //create transaction on landlord
        (new CreateNewTransactionAction)->execute([
            'reference'      => $reference,
            'amount'         => $featureAddon->amount,
            'user_reference' => ScoolynTenant::current()->schoolAdmin->email,
            'tenant_id'      => ScoolynTenant::current()->id,
            'addon_id'       => $featureAddon->uuid,
            'currency'       => 'ngn'
        ]);

        return redirect()->to($response['checkoutLink']);
    }

}
