<?php

namespace Database\Seeders\Tenant;

use App\Models\Tenant\AcademicTerm;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class AcademicTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $terms = [
            ['name' => 'first', 'number' => 1],
            ['name' => 'second', 'number' => 2],
            ['name' => 'third', 'number' => 3],
        ];

        foreach ($terms as $term){
            AcademicTerm::query()->create([
                'name'   => $term['name'],
                'uuid'   => Uuid::uuid4(),
                'number' => $term['number'],
            ]);
        }
    }
}
