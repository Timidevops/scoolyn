<?php


namespace App\Actions\Landlord\Onboarding;


use App\Models\Tenant\StudentParent;
use Ramsey\Uuid\Uuid;

class CreateDummyParentAction
{
    public function execute($adminUser)
    {
        StudentParent::query()->create([
            'uuid' => Uuid::uuid4(),
            'user_id' => (string) $adminUser->uuid,
            'first_name' => 'dummy',
            'last_name' => 'parent',
            'email' => 'dummy@scoolyn.com',
            'phone_number' => '12345',
            'gender' => 'male',
        ]);
    }
}
