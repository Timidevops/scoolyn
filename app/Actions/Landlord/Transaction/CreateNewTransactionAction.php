<?php


namespace App\Actions\Landlord\Transaction;


use App\Models\Landlord\Transaction;

class CreateNewTransactionAction
{
    public function execute(array $input)
    {
        Transaction::query()->create($input);
    }
}
