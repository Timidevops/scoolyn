<?php

namespace Database\Seeders\Landlord;

use App\Models\Landlord\Feature;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            [
                'name' => Feature::TOTAL_NUMBER_OF_STUDENT,
                'uuid' => Uuid::uuid4(),
                'description' => 'the total number of students the school can have',
                'value' => '1',
            ],
            [
                'name' => Feature::ADMISSION_AUTOMATION,
                'uuid' => Uuid::uuid4(),
                'description' => 'admission automation',
                'value' => '1',
            ],
        ];

        foreach ($features as $feature){
            Feature::query()->create($feature);
        }
    }
}
