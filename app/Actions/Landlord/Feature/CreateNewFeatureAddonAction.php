<?php


namespace App\Actions\Landlord\Feature;


use App\Models\Landlord\FeatureAddon;
use Ramsey\Uuid\Uuid;

class CreateNewFeatureAddonAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        FeatureAddon::query()->create($input);
    }
}
