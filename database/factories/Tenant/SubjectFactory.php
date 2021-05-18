<?php

namespace Database\Factories\Tenant;

use App\Models\Tenant\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;
use function Webmozart\Assert\Tests\StaticAnalysis\string;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => (string) Uuid::uuid4(),
            'subject_name' => 'further maths',
        ];
    }
}
