<?php

namespace Database\Factories\Tenant;

use App\Models\Tenant\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => (string) Uuid::uuid4(),
            'matriculation_number' => '101012',
            'first_name' => 'john',
            'last_name' => 'doe',
            'school_class_id' => 18192,
            'class_section_id' => 901038,
            'class_section_category_id' => '00183',
            'parent_id' => '299293',
        ];
    }
}
