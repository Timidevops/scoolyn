<?php

namespace Database\Factories\Tenant;

use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => (string) Uuid::uuid4(),
            'name' => 'john doe',
            'email' => 'john.doe@test.com',
            'password' => 'password'
        ];
    }
}
