<?php

namespace Database\Factories\Tenant;

use App\Models\Tenant\FeeStructure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class FeeStructureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FeeStructure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => (string) Uuid::uuid4(),
            'name' => 'school fees',
            'amount' => 200000,
        ];
    }
}
