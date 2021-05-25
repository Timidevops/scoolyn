<?php

namespace Database\Factories\Tenant;

use App\Models\Tenant\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class SchoolClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SchoolClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => (string) Uuid::uuid4(),
            'class_name' => 'sss one'
        ];
    }
}
