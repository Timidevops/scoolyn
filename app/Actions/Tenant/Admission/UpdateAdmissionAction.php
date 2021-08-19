<?php


namespace App\Actions\Tenant\Admission;


use Illuminate\Database\Eloquent\Model;

class UpdateAdmissionAction
{
    public function execute(Model $model, array $input)
    {
        $model->update($input);
    }
}
