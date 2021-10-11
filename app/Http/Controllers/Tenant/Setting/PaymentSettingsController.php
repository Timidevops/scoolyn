<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\Payments\CreateSubAccountInFlutterwave;
use App\Actions\Tenant\Payments\UpdateSubAccountInFlutterwave;
use App\Actions\Tenant\Services\PaymentService;
use App\Actions\Tenant\Setting\SchoolDetails\UpdateSchoolDetailsAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use Digikraaft\Flutterwave\Bank;
use Digikraaft\Flutterwave\Flutterwave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentSettingsController extends Controller
{
    public function edit()
    {
        try {
            PaymentService::setFlutterwaveSecretKey();
            $banks = Bank::list('NG');
            $hasSetting = Setting::has('flutterwave_sub_account_ref');
            return view('tenant.pages.setting.paymentSetting.edit', [
                'banks' => $banks,
                'schoolDetails' => Setting::schoolDetails(),
                'accountNumber' => $hasSetting ? Setting::whereSettingName('flutterwave_sub_account_ref')
                    ->first()['meta']['account_number'] : '',
                'bankCode' => $hasSetting ? Setting::whereSettingName('flutterwave_sub_account_ref')
                    ->first()['meta']['account_bank'] : '',
                'setting' => $hasSetting? '1' : '0',
            ]);

        }catch (\Exception $e) {
            Log::info("Failed to retrieve list of banks via flutterwave. ". $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'bank' => ['required', 'numeric'],
            'accountNumber' => ['required', 'numeric'],
            'setting' => ['required'],
        ]);

        if($request->setting == '1'){
            $sub = $this->updateAccount($request->bank, $request->accountNumber);

            if(! $sub){
                Session::flash('errorFlash', 'Payment details could not be saved. Please try again later.');
                return back();
            }

            Session::flash('successFlash', 'Payment details updated successfully!');
            return back();
        }

        $sub = $this->createAccount($request->bank, $request->accountNumber);
        if(! $sub){
            Session::flash('errorFlash', 'Payment details could not be saved. Please try again later.');
            return back();
        }

        Session::flash('successFlash', 'Payment details saved successfully!');
        return back();
    }

    private function createAccount($bank, $accountNumber)
    {
        $subAccount = (new CreateSubAccountInFlutterwave())->execute([
            'account_bank' => $bank,
            'account_number' => $accountNumber,
        ]);

        if(! $subAccount){
            return false;
        }

        return true;
    }
    private function updateAccount($bank, $accountNumber)
    {
        $setting = Setting::whereSettingName('flutterwave_sub_account_ref')
            ->first();
        $subAccount = (new UpdateSubAccountInFlutterwave())->execute($setting['meta']['sub_account_id'], [
            'account_bak' => $bank,
            'account_number' => $accountNumber,
        ]);

        if(! $subAccount){
            return false;
        }
        return true;
    }
}
