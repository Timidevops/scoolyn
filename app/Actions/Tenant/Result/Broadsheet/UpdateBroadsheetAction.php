<?php


namespace App\Actions\Tenant\Result\Broadsheet;


use Illuminate\Database\Eloquent\Model;

class UpdateBroadsheetAction
{
    public function execute(Model $academicBroadsheet, array $input)
    {
        $academicBroadsheet->update($input);
    }
}
