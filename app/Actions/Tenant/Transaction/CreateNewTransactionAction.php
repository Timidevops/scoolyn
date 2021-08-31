<?php


namespace App\Actions\Tenant\Transaction;


use App\Models\Tenant\Setting;
use App\Models\Tenant\Transaction;

class CreateNewTransactionAction
{
    public function execute(array $input)
    {
        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        Transaction::query()->create($input);
    }
}
