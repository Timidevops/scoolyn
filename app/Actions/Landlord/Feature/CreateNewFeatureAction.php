<?php


namespace App\Actions\Landlord\Feature;


use App\Models\Landlord\Feature;
use Ramsey\Uuid\Uuid;

class CreateNewFeatureAction
{
    public function execute(array  $input)
    {
        $input['uuid'] = Uuid::uuid4();

        Feature::query()->create($input);
    }
}
