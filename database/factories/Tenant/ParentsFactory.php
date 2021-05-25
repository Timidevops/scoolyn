<?php

namespace Database\Factories\Tenant;

use App\Models\Tenant\Parents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class ParentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => (string) Uuid::uuid4(),
            'full_name' => 'john doe',
        ];
    }
}
