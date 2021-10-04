<?php

namespace Database\Seeders\Tenant;

use App\Models\Tenant\SchoolClass;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class SchoolClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schoolClasses = [
            'Junior Secondary School 1',
            'Junior Secondary School 2',
            'Junior Secondary School 3',
            'Senior Secondary School 1',
            'Senior Secondary School 2',
            'Senior Secondary School 3',
        ];

//        foreach ($schoolClasses as $key => $schoolClass){
//            SchoolClass::query()->create([
//                'uuid' => Uuid::uuid4(),
//                'class_name' => $schoolClass,
//                'level' => $key + 1,
//            ]);
//        }
    }
}
