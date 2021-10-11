<?php


    namespace App\Actions\Tenant\Payments;


    use App\Actions\Tenant\Services\PaymentService;
    use App\Models\Tenant\Setting;
    use Digikraaft\Flutterwave\Flutterwave;
    use Digikraaft\Flutterwave\SubAccount;
    use Illuminate\Support\Facades\Log;

    class UpdateSubAccountInFlutterwave
    {
        public function execute(string $id, array $input)
        {
            $schoolDetails = Setting::schoolDetails();
            PaymentService::setFlutterwaveSecretKey();

            try{
                $subAccount = SubAccount::update($id, $input);

                if($subAccount->status == 'error') {
                    Log::info("Failed to update Flutterwave subAccount for ". $schoolDetails['schoolName']. ". Error ". $subAccount->message);
                    return false;
                }
                Setting::whereSettingName('flutterwave_sub_account_ref')
                    ->first()
                    ->update([
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
                Log::info("Failed to update Flutterwave subAccount for ". $schoolDetails['schoolName']. "error message ". $e->getMessage());
                return false;
            }
        }
    }
