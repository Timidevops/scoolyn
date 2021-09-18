<?php


    namespace App\Actions\Tenant\Payments;


    use App\Actions\Tenant\Services\PaymentService;
    use App\Models\Tenant\Setting;
    use Digikraaft\Flutterwave\Flutterwave;
    use Digikraaft\Flutterwave\SubAccount;
    use Illuminate\Support\Facades\Log;

    class CreateSubAccountInFlutterwave
    {
        public function execute(array $input)
        {
            if(! in_array_all([
                "account_bank",
                "account_number",
            ], $input)){
                return false;
            }

            $schoolDetails = Setting::schoolDetails();
            $input["business_name"] = $schoolDetails['schoolName'];
            $input["country"] = "NG";
            $input["split_value"] = config('env.payments.flutterwave.split_value');
            $input["business_mobile"] = $schoolDetails['contactNumber'];
            $input["business_email"] = $schoolDetails['contactEmail'];
            $input["split_type"] = config('env.payments.flutterwave.split_type');
            $input["meta"]["meta_app_name"] = config('app.name');

            PaymentService::setFlutterwaveSecretKey();

            try{
                $subAccount = SubAccount::create($input);

                if($subAccount->status == 'error') {
                    Log::info("Failed to create Flutterwave subAccount for ". $schoolDetails['schoolName']. ". Error ". $subAccount->message);
                    return false;
                }

                Setting::create([
                    'setting_name' => 'flutterwave_sub_account_ref',
                    'setting_value' => $subAccount->data->subaccount_id,
                    'meta' => [
                        'sub_account_id' => $subAccount->data->id,
                        'account_number' => $subAccount->data->account_number,
                        'account_bank' => $subAccount->data->account_bank,
                        'account_name' => $subAccount->data->full_name,
                        'bank_name' => $subAccount->data->bank_name,
                    ],
                ]);
                return $subAccount;
            }catch (\Exception $e){
                Log::info("Failed to create Flutterwave subAccount for ". $schoolDetails['schoolName']. "error message ". $e->getMessage());
                return false;
            }
        }
    }
